<?php

namespace Modules\Offer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Offer\Transformers\Api\OfferResource;
use Modules\Offer\Repositories\Api\OfferRepository as Offer;
use Modules\Apps\Http\Controllers\Api\ApiController;

class OfferController extends ApiController
{

    function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    public function offers()
    {
        $offers =  $this->offer->getAllActivePaginate();

        return OfferResource::collection($offers);
    }

    public function offer($id)
    {
        $offer = $this->offer->findById($id);

        if(!$offer)
          return $this->response([]);

        return $this->response(new OfferResource($offer));
    }
}
