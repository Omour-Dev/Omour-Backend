<?php

namespace Modules\Area\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Area extends Model implements TranslatableContract
{
    use Translatable , SoftDeletes , ScopesTrait;

    protected $with 					    = ['translations'];
  	protected $fillable 					= ['status' , 'state_id' ];
  	public $translatedAttributes 	= [ 'title' , 'slug' ];
    public $translationModel 			= AreaTranslation::class;

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
