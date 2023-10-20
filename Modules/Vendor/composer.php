<?php

view()->composer(['vendor::dashboard.vendors.*'], \Modules\Vendor\ViewComposers\Dashboard\VendorStatusComposer::class);

view()->composer([
    'product::dashboard.products.*',
    'variation::dashboard.*',
    'offer::dashboard.*',
    'attribute::dashboard.*',
], \Modules\Vendor\ViewComposers\Dashboard\VendorComposer::class);
