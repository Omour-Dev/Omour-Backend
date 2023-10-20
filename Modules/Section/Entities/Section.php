<?php

namespace Modules\Section\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Section extends Model implements TranslatableContract
{
  	use Translatable , SoftDeletes , ScopesTrait;

    protected $with               = [ 'translations' ];
  	protected $fillable 					= [ 'status' , 'image' ];

    public $translatedAttributes 	= [ 'description' , 'title' , 'slug'];
    public $translationModel 			= SectionTranslation::class;

    public function vendors()
    {
        return $this->belongsToMany(\Modules\Vendor\Entities\Vendor::class , 'vendor_sections');
    }
}
