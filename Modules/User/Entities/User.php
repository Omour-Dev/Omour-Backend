<?php

namespace Modules\User\Entities;

use Laravel\Passport\HasApiTokens;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable , ScopesTrait , HasApiTokens;

    use EntrustUserTrait {
      restore as private restoreA;
    }
    use SoftDeletes {
      restore as private restoreB;
    }

    protected $dates = [
      'deleted_at'
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'image'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function vendor()
    {
        return $this->hasOne(\Modules\Vendor\Entities\VendorSeller::class);
    }

    public function driverOrders()
    {
        return $this->hasMany(\Modules\User\Entities\OrderDriver::class);
    }
}
