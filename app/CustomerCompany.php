<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string customer_id
 * @property string name
 * @property string contact_number
 * @property string contact_person
 * @property string gst_number
 */
class CustomerCompany extends Model {

    protected $fillable = [
        'customer_id', 'name', 'contact_number', 'contact_person', 'gst_number'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
