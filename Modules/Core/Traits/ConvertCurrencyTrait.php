<?php

namespace Modules\Core\Traits;

use PHPHtmlParser\Dom;

trait ConvertCurrencyTrait
{
    public static function convert($currencyCode)
    {
        $currencies = self::xeConvert();

        $result = [];

        foreach ($currencies as $key => $row) {
            if ($key === 0) {
                continue;
            }

            $code = $row->find('a')[0]->text;
            $rate = $row->find('td')[2]->text;
            $result[$code] = $rate;

        }

        if (isset($result[$currencyCode]) ) {
          return $result[$currencyCode];
        }

        return false;
    }

    public static function xeConvert()
    {
        $date = date('Y-m-d' , strtotime("yesterday"));
        $dom = new Dom;
        $dom->loadFromUrl("https://www.xe.com/currencytables/?from=".setting('default_currency')."&date={$date}");
        $content = $dom->find('#historicalRateTbl tr');

        return $content;
    }
}
