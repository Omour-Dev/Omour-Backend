<?php

namespace Modules\Variation\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Option extends Model implements TranslatableContract
{
  	use Translatable , ScopesTrait;

    protected $with                = ['translations'];
  	protected $fillable 		   = ['status' , 'code' , 'vendor_id'];
  	public $translatedAttributes   = ['title'];
    public $translationModel 	   = OptionTranslation::class;

    public function values()
    {
        return $this->hasMany(OptionValue::class);
    }

    public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }
}
