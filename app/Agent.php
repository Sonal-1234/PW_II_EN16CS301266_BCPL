<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer user_id
 * @property string name
 * @property string phone1
 * @property string phone2
 * @property string email
 */
class Agent extends Model {

    protected $fillable = [
        'user_id', 'name', 'phone1', 'phone2', 'email'
    ];
}
