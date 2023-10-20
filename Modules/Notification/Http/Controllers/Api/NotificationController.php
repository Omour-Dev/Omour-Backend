<?php

namespace Modules\Notification\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Notification\Transformers\Api\NotificationResource;

class NotificationController extends ApiController
{
    public function list(Request $request)
    {
        $user = auth()->user();

        $general = $user->notifications->where('type','Modules\Notification\Notifications\GeneralNotification');

        return NotificationResource::collection($general);
    }

    public function readNotification(Request $request)
    {
        auth()->user()->unreadNotifications()->where('id',$request['id'])->update(['read_at' => now()]);

        return $this->response([]);
    }

    public function delete(Request $request)
    {
        auth()->user()->unreadNotifications()->where('id',$request['id'])->delete();

        return $this->response([]);
    }

    public function clearAll(Request $request)
    {
        auth()->user()->notifications()->delete();

        return $this->response([]);
    }
}
