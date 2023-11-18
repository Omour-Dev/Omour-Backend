<?php

namespace Modules\Authentication\Http\Controllers\Frontend;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
// use Modules\Apps\Http\Controllers\Api\Frontend;
use Modules\Authentication\Repositories\Api\UserApp\AuthenticationRepository as Authentication;

class ResetPasswordController extends Controller
{
    function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function resetPassword(Request $request)
    {
       
    }
    public function updatePassword(Request $request)
    {
       
    }
}
