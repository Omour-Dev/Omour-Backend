<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;

class VendorSeller extends Model
{
    protected $fillable = [ 'vendor_id' , 'image'];
    protected $table    = 'vendor_sellers';

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
