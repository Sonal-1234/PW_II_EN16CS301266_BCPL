<?php

namespace App\Console\Commands;

use App\CustomerService;
use App\Mail\SendInvoiceMail;
use App\Mail\SendInvoiceReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DueInvoiceReminder extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:reminder';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoice reminder of customer';

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
        $customerServices = CustomerService::whereExpireDate(date('Y-m-d', strtotime(' -5 days')))->get();
        $query = DB::getQueryLog();
        if (!empty($customerServices)):
            Log::info('due invoice reminder send');
            foreach ($customerServices as $index => $customerService) :
                if (empty($customerService)) continue;
                if ($customerService->customerAccount == 'DE-ACTIVE') continue;

                if (empty($customerService->customerAccount->customer->email)) continue;

                Mail::to($customerService->customerAccount->customer->email)->cc('billing@ekowebtech.net')->cc('support@ekowebtech.net')->send(new SendInvoiceReminderMail($customerService));
                $customerService->update(['expire_date' => date('Y-m-d', strtotime("+{$customerService->frequency} months", strtotime($customerService->expire_date)))]);
            endforeach;
        endif;
    }
}
