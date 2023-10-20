<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
  	protected $fillable  = [ 'start' , 'end' , 'code' , 'fixed' , 'percentage' , 'status'];
}
