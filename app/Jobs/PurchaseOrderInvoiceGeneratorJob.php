<?php

namespace App\Jobs;

use App\CustomerService;
use App\Invoice;
use App\Mail\SendInvoiceMail;
use Illuminate\Support\Facades\Mail;
use PDF;
use App\Customer;
use App\Organization;
use App\PurchaseOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PurchaseOrderInvoiceGeneratorJob implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $purchaseOrderId;

    /**
     * Create a new job instance.
     *
     * @param $purchaseOrderId
     */
    public function __construct($purchaseOrderId) {
        $this->purchaseOrderId = $purchaseOrderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Log::info('Purchase Order Invoice Generator Job Successfully Run. Order id: ' . $this->purchaseOrderId);
        $purchaseOrder = PurchaseOrder::findOrFail($this->purchaseOrderId);
        $organization = Organization::whereIsDefault(1)->first();
        $customer = Customer::findOrFail($purchaseOrder->customer_id);
        $invoice = Invoice::whereOrderId($this->purchaseOrderId)->first();
        $customerService = CustomerService::whereOrderId($this->purchaseOrderId)->first();

        $pdf = PDF::loadView('template.invoice', ['organization' => $organization, 'customer' => $customer, 'invoice' => $invoice, 'purchaseOrder' => $purchaseOrder, 'customerService' => $customerService]);
        $pdf->save('storage/app/public/invoices/' . $purchaseOrder->po_number . '.pdf');

        Mail::to('sbs@altctrl.digital')->cc('billing@ekowebtech.net')->cc('support@ekowebtech.net')->cc('prakashthetux@gmail.com')->send(new SendInvoiceMail($purchaseOrder->po_number));
        Log::info('Purchase Order Invoice Generator Job end.');
    }
}
