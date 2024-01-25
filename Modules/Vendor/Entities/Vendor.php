<?php

namespace Modules\Vendor\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Vendor extends Model implements TranslatableContract
{
  	use Translatable , SoftDeletes , ScopesTrait;

    protected $with 					= [ 'translations' ];
    public $translationModel 			= VendorTranslation::class;

    public $translatedAttributes 	= [
      'description' , 'title' , 'slug'
    ];

    protected $fillable 			    = [
      'status' , 'image' , 'vendor_status_id','delivery_time'
    ];

    public function openingStatus()
    {
        return $this->belongsTo(VendorStatus::class , 'vendor_status_id');
    }

    public function sections()
    {
        return $this->belongsToMany(\Modules\Section\Entities\Section::class , 'vendor_sections');
    }

    public function areas()
    {
        return $this->belongsToMany(\Modules\Area\Entities\Area::class , 'vendor_areas');
    }

    public function orders()
    {
        return $this->hasMany(\Modules\Order\Entities\Order::class);
    }

    public function rates()
    {
        return $this->hasMany(\Modules\Order\Entities\OrderRate::class);
    }

    public function products()
    {
        return $this->hasMany(\Modules\Product\Entities\Product::class);
    }

    public function images()
    {
        return $this->hasMany(VendorImage::class);
    }

     public function offers()
    {
        return $this->belongsToMany(\Modules\Offer\Entities\Offer::class , 'offer_vendors');
    }

    public function sellers()
    {
        return $this->belongsToMany(\Modules\User\Entities\User::class,'vendor_sellers','vendor_id' , 'seller_id');
    }
}
