<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class ProductNewArrival extends Model
{
    use ScopesTrait;

    protected $fillable = [ 'product_id' , 'start_at' , 'end_at' , 'status'];
}
