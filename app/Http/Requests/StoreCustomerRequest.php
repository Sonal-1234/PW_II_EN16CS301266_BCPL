<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'customer_phone1' => 'required',
            /*'email' => 'required|email|unique:users,email',*/
            'email' => 'nullable|email',
            'billing_address1' => 'required',
            'billing_city' => 'required',
            'billing_state' => 'required',
            'billing_postal_code' => 'required',
            'billing_phone1' => 'required',
            'installation_address1' => 'required',
            'installation_city' => 'required',
            'installation_state' => 'required',
            'installation_postal_code' => 'required',
            'installation_phone1' => 'required',
            'company_name' => 'required',
            'contact_number' => 'required',
            'contact_person' => 'required',
            /*'gst_number' => 'required',*/
        ];
    }
}
