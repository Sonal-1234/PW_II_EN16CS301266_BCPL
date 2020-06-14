<?php

namespace App\Mail;

use App\Invoice;
use PDF;
use App\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class SendInvoiceReminderMail extends Mailable {

    use Queueable, SerializesModels;
    private $customerService;

    /**
     * Create a new message instance.
     *
     * @param $customerService
     */
    public function __construct($customerService) {
        //
        $this->customerService = $customerService;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $uniqid = uniqid();

        $organization = Organization::whereIsDefault(1)->first();
        $invoice = Invoice::whereOrderId($this->customerService->order_id)->first();
        $pdf = PDF::loadView('template.reminder-invoice', ['organization' => $organization, 'customer' => $this->customerService->customerAccount->customer, 'invoice' => $invoice, 'customerService' => $this->customerService]);
        $pdf->setOptions(['dpi' => 100, 'defaultFont' => 'sans-serif'])->save('storage/app/public/invoices/' . $uniqid . '.pdf');

        $invoice = Storage::disk('public')->path('invoices/' . $uniqid . '.pdf');
        $this->from('billing@ekowebtech.net');
        $this->subject('Invoice Reminder');
        if ($this->customerService->customerAccount->due_invoice_reminder == 1):
            $this->attach($invoice);
        endif;
        return $this->view('template.invoice-email-body', ['customerService' => $this->customerService]);
    }
}
