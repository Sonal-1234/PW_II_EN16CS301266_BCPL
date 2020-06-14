<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer user_id
 * @property string first_name
 * @property string last_name
 * @property string phone1
 * @property string phone2
 * @property string email
 */
class Customer extends Model {

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'phone1', 'phone2', 'email'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function accounts() {
        return $this->hasMany(CustomerAccount::class, 'customer_id', 'id');
    }

    public function account_attachments() {
        return $this->hasManyThrough(CustomerAccountAttachment::class, CustomerAccount::class, 'customer_id', 'customer_account_no', 'id', 'account_no');
    }

    public function company() {
        return $this->hasOne(CustomerCompany::class, 'customer_id', 'id');
    }

    public function addresses() {
        return $this->hasManyThrough(Address::class, User::class, 'id', 'user_id', 'id', 'id');
    }

    public function purchaseOrders() {
        return $this->hasManyThrough(PurchaseOrder::class, CustomerAccount::class, 'customer_id', 'customer_account_no', 'id', 'account_no');
    }
}
