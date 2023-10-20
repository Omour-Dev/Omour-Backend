<?php

namespace Modules\Vendor\ViewComposers\Dashboard;

use Modules\Vendor\Repositories\Dashboard\VendorRepository as Vendor;
use Illuminate\View\View;
use Cache;

class VendorComposer
{
    public $vendors = [];

    public function __construct(Vendor $vendor)
    {
        $this->vendors =  $vendor->getAllActive();
    }

    public function compose(View $view)
    {
        $view->with('vendors' , $this->vendors);
    }
}
