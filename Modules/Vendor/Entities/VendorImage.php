<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;

class VendorImage extends Model
{
    protected $fillable = [ 'vendor_id' , 'image'];
}
