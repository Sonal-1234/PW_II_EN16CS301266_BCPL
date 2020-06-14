<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property string sac_code
 * @property string description
 * @property double price
 * @property double cgst
 * @property double sgst
 * @property double igst
 * @property string type
 * @property integer quality
 */
class Product extends Model {

    protected $fillable = [
        'name', 'sac_code', 'description', 'price', 'cgst', 'sgst', 'igst', 'type'
    ];
}
