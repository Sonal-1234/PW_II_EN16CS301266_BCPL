<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer order_id
 * @property string po_number
 * @property integer customer_id
 * @property integer company_name
 * @property integer customer_account_no
 * @property string status
 * @property string due_date
 * @property string order_date
 * @property integer number_of_item
 * @property double total
 * @property double discount
 * @property double taxable
 * @property double grand_total
 * @property double due_amount
 * @property string paid_at
 **/
class Invoice extends Model {

    protected $fillable = [
        'order_id', 'customer_id', 'company_name', 'customer_account_no', 'status', 'due_date', 'order_date', 'number_of_item', 'total', 'discount', 'taxable', 'grand_total', 'due_amount', 'paid_at'
    ];

    public function payment() {
        return $this->hasOne(Payment::class, 'invoice_id', 'id');
    }
}
