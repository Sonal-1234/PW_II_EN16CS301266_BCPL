<?php

namespace App\Http\Controllers;

use App\Address;
use App\Authority;
use App\Billing;
use App\Customer;
use App\CustomerAccount;
use App\CustomerAccountAttachment;
use App\CustomerCompany;
use App\CustomerService;
use App\Http\Requests\StoreCustomerRequest;
use App\Organization;
use App\Product;
use App\PurchaseOrder;
use App\PurchaseOrderAttachment;
use App\User;
use App\UserAuthority;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller {

    public function index() {
        return view('backend.customer-lists');
    }

    public function addCustomer() {
        return view('backend.customer');
    }

    public function store(StoreCustomerRequest $storeCustomerRequest) {
        $storeCustomerRequest->validated();

        try {
            DB::transaction(function () use ($storeCustomerRequest) {
                #first user creating
                $user = new User();
                $user->name = $storeCustomerRequest->first_name;
                $user->email = $storeCustomerRequest->email;
                $user->password = Hash::make('test@customer');
                $user->save();

                #set Authority of user
                $userAuthority = new UserAuthority();
                $userAuthority->user_id = $user->id;
                $userAuthority->authority_name = Authority::CUSTOMER;
                $userAuthority->save();

                #second customer create
                $customer = new Customer();
                $customer->user_id = $user->id;
                $customer->first_name = $storeCustomerRequest->first_name;
                $customer->last_name = $storeCustomerRequest->last_name;
                $customer->phone1 = $storeCustomerRequest->customer_phone1;
                $customer->phone2 = $storeCustomerRequest->customer_phone2;
                $customer->email = $storeCustomerRequest->email;
                $customer->save();

                #third customer address create
                $address = new Address();
                $address->user_id = $user->id;
                $address->type = Address::BILLING;
                $address->phone1 = $storeCustomerRequest->billing_phone1;
                $address->phone2 = $storeCustomerRequest->billing_phone2;
                $address->address1 = $storeCustomerRequest->billing_address1;
                $address->address2 = $storeCustomerRequest->billing_address2;
                $address->address3 = $storeCustomerRequest->billing_address3;
                $address->city = $storeCustomerRequest->billing_city;
                $address->state = $storeCustomerRequest->billing_state;
                $address->postal_code = $storeCustomerRequest->billing_postal_code;
                $address->save();

                #forth customer billing address create
                $address = new Address();
                $address->user_id = $user->id;
                $address->type = Address::INSTALLATION;
                $address->phone1 = $storeCustomerRequest->installation_phone1;
                $address->phone2 = $storeCustomerRequest->installation_phone2;
                $address->address1 = $storeCustomerRequest->installation_address1;
                $address->address2 = $storeCustomerRequest->installation_address2;
                $address->address3 = $storeCustomerRequest->installation_address3;
                $address->city = $storeCustomerRequest->installation_city;
                $address->state = $storeCustomerRequest->installation_state;
                $address->postal_code = $storeCustomerRequest->installation_postal_code;
                $address->save();

                #five customer Account Create
                $customerAccount = new CustomerAccount();
                $customerAccount->customer_id = $customer->id;
                $customerAccount->account_no = time();
                $customerAccount->status = CustomerAccount::ACTIVE;
                $customerAccount->save();

                #six customer company create
                $customerCompany = new CustomerCompany();
                $customerCompany->customer_id = $customer->id;
                $customerCompany->name = $storeCustomerRequest->company_name;
                $customerCompany->contact_person = $storeCustomerRequest->contact_person;
                $customerCompany->contact_number = $storeCustomerRequest->contact_number;
                $customerCompany->gst_number = $storeCustomerRequest->gst_number;
                $customerCompany->save();
            });
        } catch (Exception $e) {
            return self::errorResponse((string)$e->getMessage());
        }

        #TODO customer registration mail send
        return self::successResponse('Customer Data Successfully Saved.');
    }

    public function addAccount(Request $request) {
        #five customer Account Create
        DB::transaction(function () use ($request) {
            $customerAccount = new CustomerAccount();
            $customerAccount->customer_id = $request->customer_id;
            $customerAccount->account_no = $request->account_no;
            $customerAccount->due_invoice_reminder = (int)$request->due_invoice_reminder;
            $customerAccount->invoice_reminder = (int)$request->invoice_reminder;
            $customerAccount->description = $request->description;
            $customerAccount->status = CustomerAccount::ACTIVE;
            $customerAccount->save();

            if ($attachments = $request->file('attachment')) :
                foreach ($attachments as $i => $attachment) :
                    $extension = $attachment->getClientOriginalExtension();
                    $attachmentName = now()->getTimestamp() . $i . '.' . $extension;

                    # upload original image
                    Storage::disk('local')->putFileAs('public/upload', $attachment, $attachmentName);

                    CustomerAccountAttachment::create([
                        'customer_account_no' => $customerAccount->account_no,
                        'name' => $attachmentName
                    ]);
                endforeach;
            endif;
        });
        return self::successResponse('Customer Account Data Successfully Saved.');
    }

    public function addBilling(Request $request) {
        //Validation is pending
        $productDetail = Product::findOrFail($request->product_id);

        $igst = false;
        $customer = Customer::findOrFail($request->customer_id);
        $organization = Organization::get()->first();

        $customerGstNo = Str::substr($customer->company->gst_number, 0, 2);
        $organizationGstNo = Str::substr($organization->gstin_no, 0, 2);

        if ($customerGstNo == $organizationGstNo):
            $igst = true;
        endif;

        $subTotal = $productDetail->price - $request->discount;
        $taxable = ($subTotal * 18) / 100;
        $grand_total = $subTotal + $taxable;

        $billing = new Billing();
        $billing->customer_account_no = $request->account_no;
        $billing->product_name = $productDetail->name;
        $billing->sac_code = $productDetail->sac_code;
        $billing->price = $productDetail->price;
        $billing->quantity = $request->quantity;
        $billing->discount = $request->discount;
        $billing->total = $subTotal;
        $billing->sgst = $igst === false ? ($subTotal * 9) / 100 : 0;
        $billing->cgst = $igst === false ? ($subTotal * 9) / 100 : 0;
        $billing->igst = $igst === true ? ($subTotal * 18) / 100 : 0;
        $billing->taxable = $taxable;
        $billing->grand_total = $grand_total;
        $billing->save();

        return self::successResponse('Customer Billing Data Successfully Saved.');
    }

    public function show($id) {
        $customer = Customer::find($id);
        $products = Product::whereType('ONE_TIME_COST_PRODUCT')->get();
        $services = Product::whereType('SERVICE_BASE_PRODUCT')->get();
        return view('backend.customer-profile', compact('customer', 'products', 'services'));
    }

    public function edit($id) {
        try {
            $customerDetail = Customer::find($id);
            return response()->json(['error' => false, 'data' => $customerDetail]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function companyEdit($id) {
        try {
            $customerCompanyDetail = CustomerCompany::find($id);
            return response()->json(['error' => false, 'data' => $customerCompanyDetail]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function addressEdit($id) {
        try {
            $customerAddressDetail = Address::find($id);
            return response()->json(['error' => false, 'data' => $customerAddressDetail]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function serviceEdit($id) {
        try {
            $customerServiceDetail = CustomerService::find($id);
            return response()->json(['error' => false, 'data' => $customerServiceDetail]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function serviceUpdate(Request $request) {
        $productDetail = Product::whereId($request->plan)->first();

        $gstAmount = $productDetail->price * 18 / 100;

        $customerService = CustomerService::findOrFail($request->id);
        $customerService->plan = $productDetail->name;
        $customerService->sac_code = $productDetail->sac_code;
        $customerService->frequency = $request->frequency;
        $customerService->amount = $productDetail->price;
        $customerService->sgst = $gstAmount / 2;
        $customerService->cgst = $gstAmount / 2;
        $customerService->taxable = $gstAmount;
        $customerService->grand_total = $productDetail->price + $gstAmount;
        $customerService->save();
        return self::successResponse('Customer Service data successfully updated.');
    }

    public function update(Request $request) {
        $customer = Customer::findOrFail($request->id);
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone1 = $request->phone1;
        $customer->phone2 = $request->phone2;
        $customer->save();
        return self::successResponse('Customer data successfully updated.');
    }

    public function companyUpdate(Request $request) {
        $customerCompany = CustomerCompany::findOrFail($request->id);
        $customerCompany->name = $request->name;
        $customerCompany->contact_person = $request->contact_person;
        $customerCompany->contact_number = $request->contact_number;
        $customerCompany->gst_number = $request->gst_number;
        $customerCompany->save();
        return self::successResponse('Customer Company data successfully updated.');
    }

    public function addressUpdate(Request $request) {
        $address = Address::findOrFail($request->id);
        $address->phone1 = $request->phone1;
        $address->phone2 = $request->phone2;
        $address->address1 = $request->address1;
        $address->address2 = $request->address2;
        $address->address3 = $request->address3;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->postal_code = $request->postal_code;
        $address->save();
        return self::successResponse('Customer Address data successfully updated.');
    }

    public function destroy($id) {
        try {
            $customer = Customer::findOrFail($id);
            User::destroy($customer->user_id);
            $customerAccountNumber = Customer::destroy($id);
            return response()->json(['error' => false, 'data' => $customerAccountNumber]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function details($id) {
        try {
            $customerAccountNumbers = [];
            $customerAccountNumber = CustomerAccount::select(['account_no', 'status', 'due_invoice_reminder'])->whereCustomerId($id)->whereStatus('ACTIVE')->get();
            foreach ($customerAccountNumber as $index => $item) :
                if (isset($item->services->status) && $item->services->status == 'ACTIVE') continue;
                $customerAccountNumbers[] = $item->toArray();
            endforeach;
            return response()->json(['error' => false, 'data' => $customerAccountNumbers]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function changeAccountStatus($id, $value) {
        try {
            $customerAccountNumber = CustomerAccount::where('account_no', '=', $id);
            $customerAccountNumber->update(['status' => $value]);
            return response()->json(['error' => false, 'data' => $customerAccountNumber]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function changeDueInvoiceReminderStatus($id, $value) {
        try {
            $customerAccountNumber = CustomerAccount::where('account_no', '=', $id);
            $customerAccountNumber->update(['due_invoice_reminder' => $value]);
            return response()->json(['error' => false, 'data' => $customerAccountNumber]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function changeInvoiceReminderStatus($id, $value) {
        try {
            $customerAccountNumber = CustomerAccount::where('account_no', '=', $id);
            $customerAccountNumber->update(['invoice_reminder' => $value]);
            return response()->json(['error' => false, 'data' => $customerAccountNumber]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function purchaseOrderLists($customerId) {

        $purchaseOrders = PurchaseOrder::select(['id', 'po_number', 'order_date', 'customer_account_no', 'total', 'discount', 'taxable', 'grand_total'])->whereCustomerId($customerId)->get();
        return DataTables::of($purchaseOrders)->addColumn('action', function ($purchaseOrder) {
            $btn = '<a href="' . url("purchase/show/{$purchaseOrder->id}") . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
            // $btn .= '<a href="#delete-' . $purchaseOrder->id . '" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            return $btn;
        })->toJson();
    }

    public function lists() {
        $customers = DB::table('customers')
            ->select('customers.id', 'customers.first_name', 'customers.last_name', 'customers.last_name', 'customer_companies.name as company_name', 'customers.phone1', 'customers.phone2', 'customers.email')
            ->join('customer_companies', 'customer_companies.customer_id', '=', 'customers.id')
            ->get();
        return DataTables::of($customers)->addColumn('action', function ($customer) {
            $btn = '<a href="' . route('customers-show', $customer->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
            $btn .= '<a href="javascript:void(0)" class="btn btn-xs btn-danger customerDelete" data-id="' . $customer->id . '"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            return $btn;
        })->toJson();
    }

    public function serviceLists($id) {
        $customerAccounts = CustomerAccount::whereCustomerId($id)->get()->toArray();
        $customerAccountNumbers = array_column($customerAccounts, 'account_no');
        $customersServices = CustomerService::select(['id', 'customer_account_no', 'status', 'plan', 'frequency', 'start_date', 'expire_date'])->whereIn('customer_account_no', $customerAccountNumbers)->get();
        return DataTables::of($customersServices)->addColumn('action', function ($customersServices) {
            $btn = '<a href="javascript:void(0)" class="btn btn-xs btn-primary getCustomerServiceDetails" data-toggle="modal" data-target="#editCustomerService" data-id="' . $customersServices->id . '"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
            return $btn;
        })->toJson();
    }

    public function billingLists($id) {
        $customerAccounts = CustomerAccount::whereCustomerId($id)->get()->toArray();
        $customerAccountNumbers = array_column($customerAccounts, 'account_no');
        $customersBillings = Billing::select(['id', 'customer_account_no', 'product_name', 'quantity', 'price', 'discount', 'total', 'taxable', 'grand_total'])->whereIn('customer_account_no', $customerAccountNumbers)->get();
        return DataTables::of($customersBillings)->addColumn('action', function ($customersBilling) {
            $btn = '<a href="' . url("customer/billing/show/{$customersBilling->id}") . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i> View</a>';
            return $btn;
        })->toJson();
    }
}
