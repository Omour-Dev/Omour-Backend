<?php

namespace Modules\Setting\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Traits\ConvertCurrencyTrait;
use Modules\Apps\Http\Controllers\Api\ApiController;

class SettingController extends ApiController
{
    use ConvertCurrencyTrait;

    public function settings()
    {
        $settings =  config('api_setting');

        return $this->response($settings);
    }

    public function convertCurrency($code)
    {
        $rate =  $this->convert($code);

        $rates = [
            'rate'  => $rate,
            'code'  => $code,
        ];

        return $this->response($rates);
    }
}
