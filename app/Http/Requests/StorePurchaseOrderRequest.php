<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseOrderRequest extends FormRequest {

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
            'user_id' => 'required',
            'po_number' => 'required',
            'sales_date' => 'required',
            'customer_id' => 'required',
            'account_id' => 'required',
            "product_name" => "required|array|min:1",
            'product_name.*' => 'required',
            "price" => "required|array|min:1",
            'price.*' => 'required',
            "quantity" => "required|array|min:1",
            'quantity.*' => 'required',
            "discount" => "required|array|min:1",
            'discount.*' => 'required',
        ];
    }
}
