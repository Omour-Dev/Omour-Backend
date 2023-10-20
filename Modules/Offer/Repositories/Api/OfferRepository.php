<?php

namespace Modules\Offer\Repositories\Api;

use Modules\Offer\Entities\Offer;

class OfferRepository
{
    function __construct(Offer $offer)
    {
        $this->offer   = $offer;
    }

    public function getAllActivePaginate($order = 'id', $sort = 'desc')
    {
        $offers = $this->offer->active()->with('vendors')->orderBy($order, $sort)->get();
        return $offers;
    }

    public function findById($id)
    {
        $offer = $this->offer->active()->where('id',$id)->first();
        return $offer;
    }
}
