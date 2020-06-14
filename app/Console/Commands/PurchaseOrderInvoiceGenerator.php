<?php

namespace App\Console\Commands;

use PDF;
use App\Customer;
use App\CustomerService;
use App\Invoice;
use App\Mail\SendInvoiceMail;
use App\Organization;
use App\PurchaseOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderInvoiceGenerator extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:generate';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purchase invoice generator';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        Log::info('Every minute job run');

        $invoices = Invoice::whereInvoiceGenerate('No')->get();
        if (!empty($invoices)):
            foreach ($invoices as $index => $invoice) :
                Log::info('Purchase Order Invoice Generator Job Successfully Run. Order id: ' . $invoice->order_id);
                $purchaseOrder = PurchaseOrder::findOrFail($invoice->order_id);
                $organization = Organization::whereIsDefault(1)->first();
                $customer = Customer::findOrFail($purchaseOrder->customer_id);
                $customerService = CustomerService::whereOrderId($invoice->order_id)->whereStatus('ACTIVE')->first();
                if (empty($customerService)) continue;

                $pdf = PDF::loadView('template.invoice', ['organization' => $organization, 'customer' => $customer, 'invoice' => $invoice, 'purchaseOrder' => $purchaseOrder, 'customerService' => $customerService]);
                $pdf->setOptions(['dpi' => 100, 'defaultFont' => 'sans-serif'])->save('storage/app/public/invoices/' . $purchaseOrder->po_number . '.pdf');

                $afterCreateInvoice = Invoice::findOrFail($invoice->id);
                $afterCreateInvoice->invoice_generate = 'Yes';
                $afterCreateInvoice->save();

                if (empty($customer->email)) continue;

                Mail::to($customer->email)->cc('billing@ekowebtech.net')->cc('support@ekowebtech.net')->send(new SendInvoiceMail($purchaseOrder->po_number));
                Log::info('Purchase Order Invoice Generator Job end.');
            endforeach;
        endif;
    }
}
