<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @property integer order_id
 * @property string sac_code
 * @property string product_name
 * @property string quantity
 * @property double price
 * @property double discount
 * @property double total
 * */
class OrderItem extends Model {

    protected $fillable = [
        'order_id', 'sac_code', 'product_name', 'quantity', 'price', 'discount', 'total'
    ];

    public function purchaseOrder() {
        return $this->belongsTo(PurchaseOrder::class, 'order_id', 'id');
    }
}
