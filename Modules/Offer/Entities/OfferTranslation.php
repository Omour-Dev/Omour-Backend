<?php

namespace Modules\Offer\Entities;

use Illuminate\Database\Eloquent\Model;

class OfferTranslation extends Model
{
    protected $fillable = ['description' , 'title' , 'slug' , 'offer_id'];
}
