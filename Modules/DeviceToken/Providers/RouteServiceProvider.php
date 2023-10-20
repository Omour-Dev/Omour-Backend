<?php

namespace Modules\DeviceToken\Providers;

use File;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Core\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $apiModule       = '\Modules\DeviceToken\Http\Controllers\Api';
    protected $frontendModule  = '\Modules\DeviceToken\Http\Controllers\Frontend';
    protected $dashboardModule = '\Modules\DeviceToken\Http\Controllers\Dashboard';
    protected $vendorModule    = '\Modules\DeviceToken\Http\Controllers\Vendor';


    protected function mapVendorRoutes()
    {
       Route::middleware('web' , 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize')
       ->prefix(LaravelLocalization::setLocale().'/vendor')
       ->namespace($this->vendorModule)->group(function() {

           if (File::allFiles(module_path('DeviceToken', 'Routes/vendor'))) {
               foreach (File::allFiles(module_path('DeviceToken', 'Routes/vendor')) as $file) {
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

            if (File::allFiles(module_path('DeviceToken', 'Routes/dashboard'))) {
                foreach (File::allFiles(module_path('DeviceToken', 'Routes/dashboard')) as $file) {
                    require_once($file->getPathname());
                }
            }

        });
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web' , 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize')
        ->prefix(LaravelLocalization::setLocale())
        ->namespace($this->frontendModule)->group(function() {

              if (File::allFiles(module_path('DeviceToken', 'Routes/frontend'))) {
                  foreach (File::allFiles(module_path('DeviceToken', 'Routes/frontend')) as $file) {
                      require_once($file->getPathname());
                  }
              }

        });
    }

    protected function mapApiRoutes()
    {
        Route::group(['prefix'=>'api' ,'middleware' => ['api'] , 'namespace' => $this->apiModule],function() {

            if (File::allFiles(module_path('DeviceToken', 'Routes/api'))) {
                foreach (File::allFiles(module_path('DeviceToken', 'Routes/api')) as $file) {
                    require_once($file->getPathname());
                }
            }

        });
    }

}
