<?php

namespace Modules\DeviceToken\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DeviceToken\Traits\FCMTrait;
use Modules\DeviceToken\Repositories\Dashboard\DeviceTokenRepository;
use Modules\User\Repositories\Dashboard\UserRepository;
use Modules\Notification\Notifications\GeneralNotification;
use Notification;

class DeviceTokenController extends Controller
{
    use FCMTrait;

    function __construct(DeviceTokenRepository $token, UserRepository $user)
    {
        $this->user  = $user;
        $this->token = $token;
    }

    public function index()
    {
        return view('devicetoken::dashboard.index');
    }

    public function send(Request $request)
    {
        $users = $this->user->getAll();

        Notification::send($users, new GeneralNotification($request));

        $devices['ios']     =  $this->token->getAll('IOS');
        $devices['android'] =  $this->token->getAll('ANDROID');

        $send = $this->sendNotification($devices,$request);

        return Response()->json([true , __('apps::dashboard.messages.created')]);
    }
}
