<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Invoice;
use App\Payment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller {

    public function index() {
        return view('backend.invoice-lists');
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $Invoice = Invoice::findOrFail($request->invoice_id);
        $paidAmount = $Invoice->paid_amount + $request->amount;
        $dueAmount = $Invoice->grand_total - $paidAmount;
        $completePayment = $Invoice->grand_total <=> $paidAmount;
        if ($completePayment == -1):
            return self::errorResponse('Paid amount cannot greater than grand total amount.');
        endif;
        DB::transaction(function () use ($request, $completePayment, $Invoice, $paidAmount, $dueAmount) {
            #Payment History
            $Payment = new Payment();
            $Payment->invoice_id = $request->invoice_id;
            $Payment->mode = $request->mode;
            $Payment->amount = $request->amount;
            $Payment->save();

            $Invoice->paid_amount = $paidAmount;
            $Invoice->due_amount = $dueAmount;
            $Invoice->payment_remarks = $request->payment_remarks;
            if ($completePayment == 0):
                #Update Payment
                $Invoice->status = 'PAID';
                $Invoice->paid_at = date('Y-m-d H:i:s');
            endif;
            $Invoice->save();
        });
        return self::successResponse('Payment Done Successfully.');
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }

    public function invoice($poNumber) {
        $invoice = Storage::disk('public')->path('invoices/' . $poNumber . '.pdf');
        if (!file_exists($invoice)) exit('Invoice generation still pending.');

        return Response::make(file_get_contents($invoice), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $poNumber . '.pdf"'
        ]);
    }

    public function lists() {
        $invoices = Invoice::select(['id', 'order_date', 'po_number', 'company_name', 'due_date', 'grand_total', 'paid_amount', 'due_amount', 'paid_at', 'payment_remarks', 'status'])->get();

        return DataTables::of($invoices)->addColumn('action', function ($invoice) {
            $viewBtn = '<a href="' . url('payments/invoice/' . $invoice->po_number) . '" target="_blank" class="btn btn-xs btn-primary"> View</a>';
            $btn = '<a href="javascript:void(0)" class="btn btn-xs btn-success"> PAID</a>';
            if ($invoice->status != 'PAID')
                $btn = '<a href="javascript:void(0)" class="btn btn-xs btn-primary doPayment" data-id="' . $invoice->id . '"><i class="glyphicon glyphicon-plus"></i> Pay</a>';
            return $viewBtn . $btn;
        })->toJson();
    }
}
