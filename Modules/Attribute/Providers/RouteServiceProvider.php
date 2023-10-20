<?php

namespace Modules\Attribute\Providers;

use File;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Core\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $apiModule       = '\Modules\Attribute\Http\Controllers\Api';
    protected $frontendModule  = '\Modules\Attribute\Http\Controllers\Frontend';
    protected $dashboardModule = '\Modules\Attribute\Http\Controllers\Dashboard';
    protected $vendorModule    = '\Modules\Attribute\Http\Controllers\Vendor';


    protected function mapVendorRoutes()
    {
       Route::middleware('web' , 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize')
       ->prefix(LaravelLocalization::setLocale().'/vendor')
       ->namespace($this->vendorModule)->group(function() {

           if (File::allFiles(module_path('Attribute', 'Routes/vendor'))) {
               foreach (File::allFiles(module_path('Attribute', 'Routes/vendor')) as $file) {
                   require_once($file->getPathname());
               }
           }

       });
    }

    protected function mapDashboardRoutes()
    {
        Route::middleware('web' , 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize')
        ->prefix(LaravelLocalization::setLocale().'/dashboard')
        ->namespace($this->dashboardModule)->group(function() {

            foreach (File::allFiles(module_path('Attribute', 'Routes/dashboard')) as $file) {
                 require_once($file->getPathname());
            }

        });
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web' , 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize')
        ->prefix(LaravelLocalization::setLocale())
        ->namespace($this->frontendModule)->group(function() {

            foreach (File::allFiles(module_path('Attribute', 'Routes/frontend')) as $file) {
                require_once($file->getPathname());
            }

        });
    }

    protected function mapApiRoutes()
    {
        Route::group(['prefix'=>'api' ,'middleware' => ['api'] , 'namespace' => $this->apiModule],function() {

            foreach (File::allFiles(module_path('Attribute', 'Routes/api')) as $file) {
                require_once($file->getPathname());
            }

        });
    }

}
