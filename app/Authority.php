<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authority extends Model {

    const ADMIN = 'ADMIN';
    const AGENT = 'AGENT';
    const CUSTOMER = 'CUSTOMER';
    public $timestamps = false;
}
