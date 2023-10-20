<?php

namespace Modules\Variation\ViewComposers\Dashboard;

use Modules\Variation\Repositories\Dashboard\OptionRepository as Option;
use Illuminate\View\View;
use Cache;

class OptionComposer
{
    public $options = [];
    public $values  = [];

    public function __construct(Option $option)
    {
        $this->values  =  $option->getAllValues();
        $this->options =  $option->getAllActiveHasValues();
    }

    public function compose(View $view)
    {
        $view->with('values'    , $this->values);
        $view->with('options'   , $this->options);
    }
}
