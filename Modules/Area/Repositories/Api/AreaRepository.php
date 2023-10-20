<?php

namespace Modules\Area\Repositories\Api;

use Modules\Area\Entities\City;
use Modules\Area\Entities\State;
use Modules\Area\Entities\Area;

class AreaRepository
{
    public $state;
    public $area;
    public $city;
    function __construct(City $city, State $state, Area $area)
    {
        $this->state   = $state;
        $this->area    = $area;
        $this->city    = $city;
    }

    public function getAllCities($order = 'id', $sort = 'desc')
    {
        $cities = $this->city->active()
            ->when(request()->has('country_id'), function ($query) {
                $query->where('country_id', request('country_id'));
            })
            ->with('states.areas')->orderBy($order, $sort)->get();
        return $cities;
    }
}
