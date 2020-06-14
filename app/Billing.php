<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer order_id
 * @property integer customer_account_no
 * @property string sac_code
 * @property string product_name
 * @property string quantity
 * @property string price
 * @property string discount
 * @property string total
 * @property string sgst
 * @property string cgst
 * @property string igst
 * @property string taxable
 * @property string grand_total
 */
class Billing extends Model {

    protected $fillable = [
        'order_id', 'customer_account_no', 'sac_code', 'product_name', 'quantity', 'price', 'discount', 'total', 'sgst', 'cgst', 'igst', 'taxable', 'grand_total'
    ];
}
