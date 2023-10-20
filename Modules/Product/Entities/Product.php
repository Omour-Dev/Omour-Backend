<?php

namespace Modules\Product\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Product extends Model implements TranslatableContract
{
    use Translatable , SoftDeletes , ScopesTrait;

    protected $with 	= ['translations'];

  	protected $fillable 	= [
      'status',
      'image' ,
      'price' ,
      'sku' ,
      'qty' ,
      'vendor_id'
   ];

  	public $translatedAttributes 	= [ 'title' , 'description' ,'slug' ];
    public $translationModel 			= ProductTranslation::class;


    public function categories()
    {
        return $this->belongsToMany(\Modules\Category\Entities\Category::class,  'product_categories');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function offer()
    {
        return $this->hasOne(ProductOffer::class);
    }

    public function arrival()
    {
        return $this->hasOne(ProductNewArrival::class);
    }

    public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }

    public function productOptions()
    {
        return $this->hasMany(\Modules\Variation\Entities\ProductOption::class);
    }

    public function productAttributes()
    {
        return $this->hasMany(\Modules\Attribute\Entities\ProductAttribute::class);
    }

    public function variants()
    {
        return $this->hasMany(\Modules\Variation\Entities\ProductVariant::class);
    }

    public function variantChosed()
    {
        return $this->hasOne(\Modules\Variation\Entities\ProductVariant::class);
    }

    public function variantValues()
    {
        return $this->hasMany(\Modules\Variation\Entities\ProductVariantValue::class);
    }
}
