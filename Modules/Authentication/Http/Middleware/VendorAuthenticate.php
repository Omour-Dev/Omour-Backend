<?php

namespace Modules\Authentication\Http\Middleware;

use Closure;
use Auth;

class VendorAuthenticate
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            if ( auth()->user()->can('vendor_access') ){
                return $next($request);
            }

            abort(403);
        }

        return $next($request);
    }
}
