<?php

namespace App\Http\Controllers;

use App\Address;
use App\Authority;
use App\Customer;
use App\CustomerAccount;
use App\CustomerCompany;
use App\Imports\CustomerImport;
use App\User;
use App\UserAuthority;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class Controller extends BaseController {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
    }

    public static function successResponse($message) {
        Session::flash('message', $message);
        Session::flash('type', 'Success!');
        Session::flash('alert-class', 'alert-success');
        return back();
    }

    public static function errorResponse($message) {
        Session::flash('message', $message);
        Session::flash('type', 'Error!');
        Session::flash('alert-class', 'alert-danger');
        return back()->withInput();
    }

    public function customerImport(Request $request) {
        set_time_limit(-1);
        $allCustomers = Excel::toArray(new CustomerImport(), $request->file('excel'));
        foreach ($allCustomers as $index => $customers) :
            foreach ($customers as $i => $importCustomer) :
                if ($i == 0) continue;

                try {
                    DB::transaction(function () use ($importCustomer) {
                        $faker = \Faker\Factory::create();

                        #first user creating
                        $user = new User();
                        $user->name = $importCustomer[1];
                        $user->email = $faker->email;
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
                        $customer->first_name = $importCustomer[1];
                        $customer->last_name = null;
                        $customer->phone1 = !empty($importCustomer[3]) ? (int)$importCustomer[3] : $faker->phoneNumber;
                        $customer->phone2 = !empty($importCustomer[4]) ? (int)$importCustomer[4] : $faker->phoneNumber;
                        $customer->email = $faker->email;
                        $customer->save();

                        #third customer address create
                        $address = new Address();
                        $address->user_id = $user->id;
                        $address->type = Address::BILLING;
                        $address->phone1 = $importCustomer[3];
                        $address->phone2 = !empty($importCustomer[4]) ? (int)$importCustomer[4] : null;
                        $address->address1 = !empty($importCustomer[7]) ? $importCustomer[7] : null;
                        $address->address2 = !empty($importCustomer[8]) ? $importCustomer[8] : null;
                        $address->address3 = !empty($importCustomer[9]) ? $importCustomer[9] : null;
                        $address->city = !empty($importCustomer[11]) ? $importCustomer[11] : null;
                        $address->state = !empty($importCustomer[12]) ? $importCustomer[12] : null;
                        $address->postal_code = !empty($importCustomer[10]) ? (int)$importCustomer[10] : null;
                        $address->save();

                        #forth customer billing address create
                        $address = new Address();
                        $address->user_id = $user->id;
                        $address->type = Address::INSTALLATION;
                        $address->phone1 = $importCustomer[3];
                        $address->phone2 = !empty($importCustomer[4]) ? (int)$importCustomer[4] : null;
                        $address->address1 = !empty($importCustomer[7]) ? $importCustomer[7] : null;
                        $address->address2 = !empty($importCustomer[8]) ? $importCustomer[8] : null;
                        $address->address3 = !empty($importCustomer[9]) ? $importCustomer[9] : null;
                        $address->city = !empty($importCustomer[11]) ? $importCustomer[11] : null;
                        $address->state = !empty($importCustomer[12]) ? $importCustomer[12] : null;
                        $address->postal_code = !empty($importCustomer[10]) ? (int)$importCustomer[10] : null;
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
                        $customerCompany->name = $importCustomer[1];
                        $customerCompany->contact_person = $importCustomer[1];
                        $customerCompany->contact_number = $importCustomer[14];
                        $customerCompany->gst_number = $importCustomer[16];
                        $customerCompany->save();
                    });
                } catch (Exception $e) {
                    dd($e);
                }
                sleep(1);
            endforeach;

        endforeach;

        dd('Done');
    }
}
