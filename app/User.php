<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string name
 * @property string email
 * @property string password
 * @property integer phone1
 * @property integer phone2
 */
class User extends Authenticatable {

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone1', 'phone2'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function authority() {
        return $this->hasOne(UserAuthority::class, 'user_id', 'id');
    }

    public function customer() {
        return $this->hasOne(Customer::class, 'user_id', 'id');
    }

    public function addresses() {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }
}
