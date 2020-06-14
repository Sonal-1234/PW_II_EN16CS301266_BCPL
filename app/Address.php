<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property integer user_id
 * @property string type
 * @property integer phone1
 * @property integer phone2
 * @property string address1
 * @property string address2
 * @property string address3
 * @property string postal_code
 * @property string city
 * @property string state
 */
class Address extends Model {

    const RESIDENCE = 'RESIDENCE';
    const BILLING = 'BILLING';
    const INSTALLATION = 'INSTALLATION';
    protected $fillable = [
        'user_id', 'type', 'phone1', 'phone2', 'address1', 'address2', 'address3', 'postal_code', 'city', 'state'
    ];
}
