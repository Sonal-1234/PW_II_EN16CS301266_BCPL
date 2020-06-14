<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property array|\Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|null name
 */
class PurchaseOrderAttachment extends Model {

    protected $fillable = [
        'order_id', 'name'
    ];
}
