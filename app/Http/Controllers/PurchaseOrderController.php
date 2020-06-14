<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerAccount;
use App\CustomerService;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Invoice;
use App\OrderItem;
use App\Organization;
use App\Product;
use App\PurchaseOrder;
use App\PurchaseOrderAttachment;
use App\User;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Cache\ArrayStore;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller {

    public function index() {
        return view('backend.purchase-orders-lists');
    }

    public function create() {
        $organization = Organization::get()->first();
        if (empty($organization)) return self::errorResponse('Please add Organization First.');
        $plans = Product::whereType('SELF_PURCHASE')->get();
        $products = Product::whereType('GOVERNMENT_CCI')->get();
        $customers = Customer::all();
        $users = $users = User::whereHas('authority', function ($q) {
            $q->where('authority_name', 'ADMIN')->orWhere('authority_name', 'AGENT');
        })->get();
        return view('backend.purchase-order', compact('customers', 'products', 'plans', 'users'));
    }

    public function customCreate() {
        $organization = Organization::get()->first();
        if (empty($organization)) return self::errorResponse('Please add Organization First.');
        $customers = Customer::all();
        $users = $users = User::whereHas('authority', function ($q) {
            $q->where('authority_name', 'ADMIN')->orWhere('authority_name', 'AGENT');
        })->get();
        return view('backend.custom-purchase-order', compact('customers', 'users'));
    }

    public function store(StorePurchaseOrderRequest $storePurchaseOrderRequest) {
        $productIds = [];
        $igst = false;
        $customerGstNo = null;
        $storePurchaseOrderRequest->validated();

        $customer = Customer::findOrFail($storePurchaseOrderRequest->customer_id);
        $organization = Organization::get()->first();

        if (!empty($customer->company->gst_number)):
            $customerGstNo = Str::substr($customer->company->gst_number, 0, 2);
        endif;
        $organizationGstNo = Str::substr($organization->gstin_no, 0, 2);

        if ($customerGstNo == $organizationGstNo):
            $igst = true;
        endif;
        $productIds[] = $storePurchaseOrderRequest->plan;

        foreach ($storePurchaseOrderRequest->product_name as $index => $item) :
            $productIdsArray[] = @explode('/', $item)[0];
        endforeach;

        foreach ($productIdsArray as $index => $item) :
            $productIds[] = $item;
        endforeach;

        try {
            DB::beginTransaction();
            $plan = Product::findOrFail($storePurchaseOrderRequest->plan);
            $totalDiscount = array_sum($storePurchaseOrderRequest->discount);
            $subTotal = array_sum($storePurchaseOrderRequest->sub_total) - $totalDiscount;
            $subTotal = $subTotal + $plan->price;

            $taxable = ($subTotal * 18) / 100;
            $grand_total = $subTotal + $taxable;

            #first create purchase order
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->po_number = $storePurchaseOrderRequest->po_number;
            $purchaseOrder->user_id = $storePurchaseOrderRequest->user_id;
            $purchaseOrder->customer_id = $storePurchaseOrderRequest->customer_id;
            $purchaseOrder->customer_account_no = $storePurchaseOrderRequest->account_id;
            $purchaseOrder->company_name = $customer->company->name;
            $purchaseOrder->order_date = $storePurchaseOrderRequest->sales_date;
            $purchaseOrder->number_of_item = count($storePurchaseOrderRequest->product_name);
            $purchaseOrder->total = $subTotal;
            $purchaseOrder->discount = $totalDiscount;
            $purchaseOrder->sgst = $igst === false ? ($subTotal * 9) / 100 : 0;
            $purchaseOrder->cgst = $igst === false ? ($subTotal * 9) / 100 : 0;
            $purchaseOrder->igst = $igst === true ? ($subTotal * 18) / 100 : 0;
            $purchaseOrder->taxable = $taxable;
            $purchaseOrder->grand_total = $grand_total;
            $purchaseOrder->save();

            #second upload purchase order attachment
            if ($attachments = $storePurchaseOrderRequest->file('attachment')) :
                foreach ($attachments as $i => $attachment) :
                    $extension = $attachment->getClientOriginalExtension();
                    $attachmentName = now()->getTimestamp() . $i . '.' . $extension;

                    # upload original image
                    Storage::disk('local')->putFileAs('public/upload', $attachment, $attachmentName);

                    PurchaseOrderAttachment::create([
                        'order_id' => $purchaseOrder->id,
                        'name' => $attachmentName
                    ]);
                endforeach;
            endif;

            #third purchase order items functionality
            $purchaseOrderItems[] = [
                'order_id' => $purchaseOrder->id,
                'sac_code' => $plan->sac_code,
                'product_name' => $plan->name,
                'quantity' => $storePurchaseOrderRequest->frequency,
                'price' => $plan->price,
                'discount' => 00.00,
                'total' => $plan->price,
            ];

            for ($x = 0; $x < count($storePurchaseOrderRequest->product_name); $x++) :
                $price = $storePurchaseOrderRequest->price[$x];
                $quantity = $storePurchaseOrderRequest->quantity[$x];
                $discount = $storePurchaseOrderRequest->discount[$x];
                $purchaseOrderItems[] = [
                    'order_id' => $purchaseOrder->id,
                    'sac_code' => explode('/', $storePurchaseOrderRequest->product_name[$x])[2],
                    'product_name' => $storePurchaseOrderRequest->product_name[$x],
                    'quantity' => $quantity,
                    'price' => $price,
                    'discount' => $discount,
                    'total' => $quantity * $price - $discount,
                ];
            endfor;

            foreach ($productIds as $i => $productId) :
                if ($i == 0):
                    $updateProduct = Product::findOrFail($productId);
                    if ($updateProduct->quality < $storePurchaseOrderRequest->frequency) return self::errorResponse('you can not purchase this product because of quality is less than to purchase quality.');
                    $updateProductQuantity = $updateProduct->quality - $storePurchaseOrderRequest->frequency;
                    $updateProduct->quality = $updateProductQuantity;
                    $updateProduct->save();
                    unset($updateProduct);
                    continue;
                endif;
                $updateProduct = Product::findOrFail($productId)->first();
                if ($updateProduct->quality < $storePurchaseOrderRequest->quantity[$i - 1]) return self::errorResponse('you can not purchase this product because of quality is less than to purchase quality.');
                $updateProductQuantity = $updateProduct->quality - $storePurchaseOrderRequest->quantity[$i - 1];
                $updateProduct->quality = $updateProductQuantity;
                $updateProduct->save();
            endforeach;
            OrderItem::insert($purchaseOrderItems);

            #four purchase order invoice functionality
            $purchaseOrderInvoice = new Invoice();
            $purchaseOrderInvoice->order_id = $purchaseOrder->id;
            $purchaseOrderInvoice->po_number = $storePurchaseOrderRequest->po_number;
            $purchaseOrderInvoice->customer_id = $storePurchaseOrderRequest->customer_id;
            $purchaseOrderInvoice->company_name = $customer->company->name;
            $purchaseOrderInvoice->customer_account_no = $storePurchaseOrderRequest->account_id;
            $purchaseOrderInvoice->order_date = $storePurchaseOrderRequest->sales_date;
            $purchaseOrderInvoice->due_date = Carbon::createFromFormat('Y-m-d', $storePurchaseOrderRequest->sales_date)->add(new DateInterval('P10D'));
            $purchaseOrderInvoice->number_of_item = count($storePurchaseOrderRequest->product_name);
            $purchaseOrderInvoice->total = $subTotal;
            $purchaseOrderInvoice->discount = $totalDiscount;
            $purchaseOrderInvoice->taxable = $taxable;
            $purchaseOrderInvoice->grand_total = $grand_total;
            $purchaseOrderInvoice->save();

            $serviceTaxableAmount = ($plan->price * 18) / 100;
            #five customer services functionality
            $customerServices = new CustomerService();
            $customerServices->order_id = $purchaseOrder->id;
            $customerServices->customer_account_no = $storePurchaseOrderRequest->account_id;
            $customerServices->status = CustomerService::ACTIVE;
            $customerServices->plan = $plan->name;
            $customerServices->sac_code = $plan->sac_code;
            $customerServices->amount = $plan->price;
            $customerServices->frequency = $storePurchaseOrderRequest->frequency;
            $customerServices->start_date = $storePurchaseOrderRequest->sales_date;
            $customerServices->expire_date = date('Y-m-d', strtotime("+{$storePurchaseOrderRequest->frequency} months", strtotime($storePurchaseOrderRequest->sales_date)));
            $customerServices->sgst = $igst === false ? ($plan->price * 9) / 100 : 0;
            $customerServices->cgst = $igst === false ? ($plan->price * 9) / 100 : 0;
            $customerServices->igst = $igst === true ? ($plan->price * 18) / 100 : 0;
            $customerServices->taxable = $serviceTaxableAmount;
            $customerServices->grand_total = $plan->price + $serviceTaxableAmount;
            $customerServices->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return self::errorResponse((string)$e->getMessage());
        }

        return self::successResponse('Purchase Order Data Successfully Saved.');
    }

    public function customStore(StorePurchaseOrderRequest $storePurchaseOrderRequest) {
        $storePurchaseOrderRequest->validated();
        $igst = false;

        $customer = Customer::findOrFail($storePurchaseOrderRequest->customer_id);
        $organization = Organization::get()->first();

        $customerGstNo = Str::substr($customer->company->gst_number, 0, 2);
        $organizationGstNo = Str::substr($organization->gstin_no, 0, 2);

        if ($customerGstNo == $organizationGstNo):
            $igst = true;
        endif;

        DB::transaction(function () use ($storePurchaseOrderRequest, $igst, $customer) {

            $totalDiscount = array_sum($storePurchaseOrderRequest->discount);
            $subTotal = $storePurchaseOrderRequest->sub_total - $totalDiscount;

            $taxable = ($subTotal * 18) / 100;
            $grand_total = $subTotal + $taxable;

            #first create purchase order
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->po_number = $storePurchaseOrderRequest->po_number;
            $purchaseOrder->user_id = $storePurchaseOrderRequest->user_id;
            $purchaseOrder->customer_id = $storePurchaseOrderRequest->customer_id;
            $purchaseOrder->customer_account_no = $storePurchaseOrderRequest->account_id;
            $purchaseOrder->company_name = $customer->company->name;
            $purchaseOrder->order_date = $storePurchaseOrderRequest->sales_date;
            $purchaseOrder->number_of_item = count($storePurchaseOrderRequest->product_name);
            $purchaseOrder->total = $subTotal;
            $purchaseOrder->discount = $totalDiscount;
            $purchaseOrder->sgst = $igst === false ? ($subTotal * 9) / 100 : 0;
            $purchaseOrder->cgst = $igst === false ? ($subTotal * 9) / 100 : 0;
            $purchaseOrder->igst = $igst === true ? ($subTotal * 18) / 100 : 0;
            $purchaseOrder->taxable = $taxable;
            $purchaseOrder->grand_total = $grand_total;
            $purchaseOrder->save();

            #second upload purchase order attachment
            if ($attachments = $storePurchaseOrderRequest->file('attachment')) :
                foreach ($attachments as $i => $attachment) :
                    $extension = $attachment->getClientOriginalExtension();
                    $attachmentName = now()->getTimestamp() . $i . '.' . $extension;

                    # upload original image
                    Storage::disk('local')->putFileAs('public/upload', $attachment, $attachmentName);

                    PurchaseOrderAttachment::create([
                        'order_id' => $purchaseOrder->id,
                        'name' => $attachmentName
                    ]);
                endforeach;
            endif;

            #third purchase order items functionality
            $purchaseOrderItems[] = [
                'order_id' => $purchaseOrder->id,
                'sac_code' => $storePurchaseOrderRequest->plan_sac_code,
                'product_name' => $storePurchaseOrderRequest->plan,
                'quantity' => $storePurchaseOrderRequest->plan_frequency,
                'price' => $storePurchaseOrderRequest->plan_price,
                'discount' => 00.00,
                'total' => $storePurchaseOrderRequest->plan_price,
            ];

            for ($x = 0; $x < count($storePurchaseOrderRequest->product_name); $x++) :
                $price = $storePurchaseOrderRequest->price[$x];
                $quantity = $storePurchaseOrderRequest->quantity[$x];
                $discount = $storePurchaseOrderRequest->discount[$x];
                $purchaseOrderItems[] = [
                    'order_id' => $purchaseOrder->id,
                    'sac_code' => $storePurchaseOrderRequest->sac_code[$x],
                    'product_name' => $storePurchaseOrderRequest->product_name[$x],
                    'quantity' => $quantity,
                    'price' => $price,
                    'discount' => $discount,
                    'total' => $quantity * $price - $discount,
                ];
            endfor;
            OrderItem::insert($purchaseOrderItems);

            #four purchase order invoice functionality
            $purchaseOrderInvoice = new Invoice();
            $purchaseOrderInvoice->order_id = $purchaseOrder->id;
            $purchaseOrderInvoice->po_number = $storePurchaseOrderRequest->po_number;
            $purchaseOrderInvoice->customer_id = $storePurchaseOrderRequest->customer_id;
            $purchaseOrderInvoice->company_name = $customer->company->name;
            $purchaseOrderInvoice->customer_account_no = $storePurchaseOrderRequest->account_id;
            $purchaseOrderInvoice->order_date = $storePurchaseOrderRequest->sales_date;
            $purchaseOrderInvoice->due_date = Carbon::createFromFormat('Y-m-d', $storePurchaseOrderRequest->sales_date)->add(new DateInterval('P10D'));
            $purchaseOrderInvoice->number_of_item = count($storePurchaseOrderRequest->product_name);
            $purchaseOrderInvoice->total = $subTotal;
            $purchaseOrderInvoice->discount = $totalDiscount;
            $purchaseOrderInvoice->taxable = $taxable;
            $purchaseOrderInvoice->grand_total = $grand_total;
            $purchaseOrderInvoice->due_amount = $grand_total;
            $purchaseOrderInvoice->save();

            $serviceTaxableAmount = ($storePurchaseOrderRequest->plan_price * 18) / 100;
            #five customer services functionality
            $customerServices = new CustomerService();
            $customerServices->order_id = $purchaseOrder->id;
            $customerServices->customer_account_no = $storePurchaseOrderRequest->account_id;
            $customerServices->status = CustomerService::ACTIVE;
            $customerServices->plan = $storePurchaseOrderRequest->plan;
            $customerServices->sac_code = $storePurchaseOrderRequest->plan_sac_code;
            $customerServices->amount = $storePurchaseOrderRequest->plan_price;
            $customerServices->frequency = $storePurchaseOrderRequest->plan_frequency;
            $customerServices->start_date = $storePurchaseOrderRequest->sales_date;
            $customerServices->expire_date = date('Y-m-d', strtotime("+{$storePurchaseOrderRequest->plan_frequency} months", strtotime($storePurchaseOrderRequest->sales_date)));
            $customerServices->sgst = $igst === false ? ($storePurchaseOrderRequest->plan_price * 9) / 100 : 0;
            $customerServices->cgst = $igst === false ? ($storePurchaseOrderRequest->plan_price * 9) / 100 : 0;
            $customerServices->igst = $igst === true ? ($storePurchaseOrderRequest->plan_price * 18) / 100 : 0;
            $customerServices->taxable = $serviceTaxableAmount;
            $customerServices->grand_total = $storePurchaseOrderRequest->plan_price + $serviceTaxableAmount;
            $customerServices->save();
        });
        return self::successResponse('Purchase Order Data Successfully Saved.');
    }

    public function update(StorePurchaseOrderRequest $storePurchaseOrderRequest) {
        $storePurchaseOrderRequest->validated();
        dd($storePurchaseOrderRequest->all());

        exit('Functionality not available.');
        $igst = false;

        $customer = Customer::findOrFail($storePurchaseOrderRequest->customer_id);
        $organization = Organization::get()->first();

        $customerGstNo = Str::substr($customer->company->gst_number, 0, 2);
        $organizationGstNo = Str::substr($organization->gstin_no, 0, 2);

        if ($customerGstNo == $organizationGstNo):
            $igst = true;
        endif;

        DB::transaction(function () use ($storePurchaseOrderRequest, $igst) {

            $totalDiscount = array_sum($storePurchaseOrderRequest->discount);
            $subTotal = $storePurchaseOrderRequest->sub_total - $totalDiscount;

            $taxable = ($subTotal * 18) / 100;
            $grand_total = $subTotal + $taxable;

            #first create purchase order
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->po_number = $storePurchaseOrderRequest->po_number;
            $purchaseOrder->user_id = $storePurchaseOrderRequest->user_id;
            $purchaseOrder->customer_id = $storePurchaseOrderRequest->customer_id;
            $purchaseOrder->customer_account_no = $storePurchaseOrderRequest->account_id;
            $purchaseOrder->order_date = $storePurchaseOrderRequest->sales_date;
            $purchaseOrder->number_of_item = count($storePurchaseOrderRequest->product_name);
            $purchaseOrder->total = $subTotal;
            $purchaseOrder->discount = $totalDiscount;
            $purchaseOrder->sgst = $igst === false ? ($subTotal * 9) / 100 : 0;
            $purchaseOrder->cgst = $igst === false ? ($subTotal * 9) / 100 : 0;
            $purchaseOrder->igst = $igst === true ? ($subTotal * 18) / 100 : 0;
            $purchaseOrder->taxable = $taxable;
            $purchaseOrder->grand_total = $grand_total;
            $purchaseOrder->save();

            #second upload purchase order attachment
            if ($attachments = $storePurchaseOrderRequest->file('attachment')) :
                foreach ($attachments as $i => $attachment) :
                    $extension = $attachment->getClientOriginalExtension();
                    $attachmentName = now()->getTimestamp() . $i . '.' . $extension;

                    # upload original image
                    Storage::disk('local')->putFileAs('public/upload', $attachment, $attachmentName);

                    PurchaseOrderAttachment::create([
                        'order_id' => $purchaseOrder->id,
                        'name' => $attachmentName
                    ]);
                endforeach;
            endif;

            #third purchase order items functionality
            $purchaseOrderItems[] = [
                'order_id' => $purchaseOrder->id,
                'sac_code' => $storePurchaseOrderRequest->plan_sac_code,
                'product_name' => $storePurchaseOrderRequest->plan,
                'quantity' => $storePurchaseOrderRequest->plan_frequency,
                'price' => $storePurchaseOrderRequest->plan_price,
                'discount' => 00.00,
                'total' => $storePurchaseOrderRequest->plan_price,
            ];

            for ($x = 0; $x < count($storePurchaseOrderRequest->product_name); $x++) :
                $price = $storePurchaseOrderRequest->price[$x];
                $quantity = $storePurchaseOrderRequest->quantity[$x];
                $discount = $storePurchaseOrderRequest->discount[$x];
                $purchaseOrderItems[] = [
                    'order_id' => $purchaseOrder->id,
                    'sac_code' => $storePurchaseOrderRequest->sac_code[$x],
                    'product_name' => $storePurchaseOrderRequest->product_name[$x],
                    'quantity' => $quantity,
                    'price' => $price,
                    'discount' => $discount,
                    'total' => $quantity * $price - $discount,
                ];
            endfor;
            OrderItem::insert($purchaseOrderItems);

            #four purchase order invoice functionality
            $purchaseOrderInvoice = new Invoice();
            $purchaseOrderInvoice->order_id = $purchaseOrder->id;
            $purchaseOrderInvoice->po_number = $storePurchaseOrderRequest->po_number;
            $purchaseOrderInvoice->customer_id = $storePurchaseOrderRequest->customer_id;
            $purchaseOrderInvoice->customer_account_no = $storePurchaseOrderRequest->account_id;
            $purchaseOrderInvoice->order_date = $storePurchaseOrderRequest->sales_date;
            $purchaseOrderInvoice->due_date = Carbon::createFromFormat('Y-m-d', $storePurchaseOrderRequest->sales_date)->add(new DateInterval('P10D'));
            $purchaseOrderInvoice->number_of_item = count($storePurchaseOrderRequest->product_name);
            $purchaseOrderInvoice->total = $subTotal;
            $purchaseOrderInvoice->discount = $totalDiscount;
            $purchaseOrderInvoice->taxable = $taxable;
            $purchaseOrderInvoice->grand_total = $grand_total;
            $purchaseOrderInvoice->due_amount = $grand_total;
            $purchaseOrderInvoice->save();

            $serviceTaxableAmount = ($storePurchaseOrderRequest->plan_price * 18) / 100;
            #five customer services functionality
            $customerServices = new CustomerService();
            $customerServices->order_id = $purchaseOrder->id;
            $customerServices->customer_account_no = $storePurchaseOrderRequest->account_id;
            $customerServices->status = CustomerService::ACTIVE;
            $customerServices->plan = $storePurchaseOrderRequest->plan;
            $customerServices->sac_code = $storePurchaseOrderRequest->plan_sac_code;
            $customerServices->amount = $storePurchaseOrderRequest->plan_price;
            $customerServices->frequency = $storePurchaseOrderRequest->plan_frequency;
            $customerServices->expire_date = date('Y-m-d', strtotime("+{$storePurchaseOrderRequest->plan_frequency} months", strtotime($storePurchaseOrderRequest->sales_date)));
            $customerServices->sgst = $igst === false ? ($storePurchaseOrderRequest->plan_price * 9) / 100 : 0;
            $customerServices->cgst = $igst === false ? ($storePurchaseOrderRequest->plan_price * 9) / 100 : 0;
            $customerServices->igst = $igst === true ? ($storePurchaseOrderRequest->plan_price * 18) / 100 : 0;
            $customerServices->taxable = $serviceTaxableAmount;
            $customerServices->grand_total = $storePurchaseOrderRequest->plan_price + $serviceTaxableAmount;
            $customerServices->save();
        });
        return self::successResponse('Purchase Order Data Successfully Saved.');
    }

    public function show($id) {
        $purchase_order = PurchaseOrder::findOrFail($id);
        return view('backend.purchase-order-view', compact('purchase_order'));
    }

    public function edit($id) {
        $purchase_order = PurchaseOrder::findOrFail($id);
        // exit('Functionality not available.');
        $plans = Product::whereType('SELF_PURCHASE')->get();
        $products = Product::whereType('GOVERNMENT_CCI')->get();
        $customers = Customer::all();
        $users = $users = User::whereHas('authority', function ($q) {
            $q->where('authority_name', 'ADMIN')->orWhere('authority_name', 'AGENT');
        })->get();
        return view('backend.purchase-order-custom-edit', compact('purchase_order', 'customers', 'products', 'plans', 'users'));
    }

    public function destroy($id) {
        try {
            $PurchaseOrder = PurchaseOrder::destroy($id);
            return response()->json(['error' => false, 'data' => $PurchaseOrder]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function itemCalculationDetails($id, $quantity) {
        try {
            $productDetail = Product::find($id);
            $subTotal = $quantity * $productDetail->price;
            return response()->json(['error' => false, 'data' => [
                'product_name' => $productDetail->id . '/' . $productDetail->name . '/' . $productDetail->sac_code,
                'price' => $productDetail->price,
                'quantity' => $quantity,
                'subtotal' => $subTotal,
            ]]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function serviceCalculationDetails($plan, $frequency) {
        try {
            $productDetail = Product::find($plan);
            $subTotal = ($frequency * $productDetail->price);
            return response()->json(['error' => false, 'data' => [
                'plan_name' => $productDetail->id . '/' . $productDetail->name . '/' . $productDetail->sac_code,
                'price' => $productDetail->price,
                'frequency' => $frequency,
                'subtotal' => $subTotal,
            ]]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function lists() {
        $purchaseOrders = PurchaseOrder::select(['id', 'po_number', 'order_date', 'company_name', 'customer_account_no', 'total', 'discount', 'taxable', 'grand_total'])->get();
        return DataTables::of($purchaseOrders)->addColumn('action', function ($purchaseOrder) {
            $btn = '<a href="' . url("purchase/show/{$purchaseOrder->id}") . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
            // $btn .= '<a href="javascript:void(0)" class="btn btn-xs btn-danger deletePO" data-id="' . $purchaseOrder->id . '"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            // $btn .= '<a href="' . url("purchase/edit/{$purchaseOrder->id}") . '" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            return $btn;
        })->toJson();
    }
}
