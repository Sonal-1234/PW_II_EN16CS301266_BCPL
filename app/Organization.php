<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string id
 * @property string name
 * @property string email
 * @property string logo
 * @property string owner_name
 * @property string organization_code
 * @property string pan_no
 * @property string gstin_no
 * @property string is_default
 * @property string registration_no
 */
class Organization extends Model {

    protected $fillable = [
        'name', 'email', 'logo', 'owner_name', 'organization_code', 'pan_no', 'gstin_no', 'is_default', 'registration_no'
    ];
    protected $casts = [
        'is_default' => 'boolean'
    ];

    public function address() {
        return $this->hasOne(OrganizationAddress::class, 'organization_id', 'id');
    }
}
