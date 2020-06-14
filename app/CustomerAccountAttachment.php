<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer customer_account_id
 * @property string name
 **/
class CustomerAccountAttachment extends Model {

    protected $fillable = [
        'customer_account_no', 'name'
    ];
}
