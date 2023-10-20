<?php

namespace Modules\Attribute\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class AttributeValue extends Model implements TranslatableContract
{
  	use Translatable , ScopesTrait;

    protected $with               = ['translations'];
  	protected $fillable 		  = ['status','attribute_id' , 'price'];
  	public $translatedAttributes  = ['title'];
    public $translationModel 	  = AttributeValueTranslation::class;

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
