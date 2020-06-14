<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest {

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
            'name' => 'required',
            'email' => 'required',
            'owner_name' => 'required',
            'pan_no' => 'required',
            'registration_no' => 'required',
            'organization_code' => 'required',
            'logo' => 'required',
            'gstin_no' => 'required',
            'is_default' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'phone1' => 'required',
        ];
    }
}
