<?php

view()->composer(['user::dashboard.admins.index'], \Modules\Authorization\ViewComposers\Dashboard\AdminRolesComposer::class);

view()->composer(['user::dashboard.vendors.index'], \Modules\Authorization\ViewComposers\Dashboard\VendorRolesComposer::class);

view()->composer(['user::dashboard.drivers.index'], \Modules\Authorization\ViewComposers\Dashboard\DriverRolesComposer::class);


view()->composer([
  'celebrity::dashboard.celebrities.index',
  'setting::dashboard.tabs.celebrities'
], \Modules\Authorization\ViewComposers\Dashboard\CelebrityRolesComposer::class);
