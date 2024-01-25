<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;

class VendorArea extends Model
{
    protected $fillable = ['vendor_id', 'area_id', 'shipping_price'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_areas')
                    ->withPivot('shipping_price');
    }

}
