<?php

namespace Modules\Area\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Area\Transformers\Api\CityResource;
use Modules\Area\Transformers\Api\StateResource;
use Modules\Area\Transformers\Api\AreaResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Area\Repositories\Api\AreaRepository as Area;

class AreaController extends ApiController
{
    public $area;

    function __construct(Area $area)
    {
        $this->area = $area;
    }

    public function cities()
    {
        $cities =  $this->area->getAllCities();
        return CityResource::collection($cities);
    }
}
