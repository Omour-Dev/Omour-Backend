<?php

namespace Modules\Attribute\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Attribute extends Model implements TranslatableContract
{
  	use Translatable , ScopesTrait;

    protected $with                = ['translations'];
  	protected $fillable 		   = ['status' , 'code' , 'vendor_id'];
  	public $translatedAttributes   = ['title'];
    public $translationModel 	= AttributeTranslation::class;

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }
}
