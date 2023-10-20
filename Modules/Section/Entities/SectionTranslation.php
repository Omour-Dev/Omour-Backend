<?php

namespace Modules\Section\Entities;

use Illuminate\Database\Eloquent\Model;

class SectionTranslation extends Model
{
    protected $fillable = ['description' , 'title' , 'slug' ];
}
