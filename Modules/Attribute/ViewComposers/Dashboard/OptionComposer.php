<?php

namespace Modules\Variation\ViewComposers\Dashboard;

use Modules\Variation\Repositories\Dashboard\AttributeRepository as Attribute;
use Illuminate\View\View;
use Cache;

class AttributeComposer
{
    public $attributes = [];
    public $values  = [];

    public function __construct(Attribute $attribute)
    {
        $this->values     =  $attribute->getAllValues();
        $this->attributes =  $attribute->getAllActiveHasValues();
    }

    public function compose(View $view)
    {
        $view->with('values'    , $this->values);
        $view->with('attributes', $this->attributes);
    }
}
