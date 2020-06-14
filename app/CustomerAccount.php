<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer customer_id
 * @property string account_no
 * @property string status
 * @property integer due_invoice_reminder
 * @property integer invoice_reminder
 * @property string description
 */
class CustomerAccount extends Model {

    const ACTIVE = 'ACTIVE';
    const DEACTIVE = 'DE-ACTIVE';
    protected $fillable = [
        'customer_id', 'account_no', 'status', 'due_invoice_reminder', 'invoice_reminder', 'description'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function services() {
        return $this->hasOne(CustomerService::class, 'customer_account_no', 'account_no');
    }

    public function invoices() {
        return $this->hasMany(Invoice::class, 'customer_account_no', 'account_no');
    }

    public function purchaseOrders() {
        return $this->hasMany(PurchaseOrder::class, 'customer_account_no', 'account_no');
    }
}
