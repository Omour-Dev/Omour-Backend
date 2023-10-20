<?php

view()->composer(['area::dashboard.cities.*'], \Modules\Area\ViewComposers\Dashboard\CountryComposer::class);

view()->composer(['area::dashboard.states.*'], \Modules\Area\ViewComposers\Dashboard\CityComposer::class);

view()->composer(['area::dashboard.areas.*' , 'vendor::dashboard.vendors.*'],
\Modules\Area\ViewComposers\Dashboard\StateComposer::class);
