<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class SendInvoiceMail extends Mailable {

    use Queueable, SerializesModels;
    private $po_number;

    /**
     * Create a new message instance.
     *
     * @param $po_number
     */
    public function __construct($po_number) {
        $this->po_number = $po_number;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $invoice = Storage::disk('public')->path('invoices/' . $this->po_number . '.pdf');
        $this->from('billing@ekowebtech.net');
        $this->subject('Invoice ' . $this->po_number);
        $this->attach($invoice);
        return $this->view('template.invoice-email-body');
    }
}
