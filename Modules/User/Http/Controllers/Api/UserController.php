<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\User\Transformers\Api\UserResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\User\Transformers\Api\UserAddressResource;
use Modules\User\Http\Requests\Api\UpdateProfileRequest;
use Modules\User\Http\Requests\Api\ChangePasswordRequest;
use Modules\User\Repositories\Api\UserRepository as User;

class UserController extends ApiController
{
    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function profile()
    {
        $user =  $this->user->userProfile();
        return $this->response(new UserResource($user));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->user->update($request);

        $user =  $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->user->changePassword($request);

        $user =  $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function addresses()
    {
        $addresses =  $this->user->addresses();
        return $this->response(UserAddressResource::collection($addresses));
    }

    public function addAddress(Request $request)
    {
        $address = $this->user->addAddress($request);

        return $this->response(new UserAddressResource($address));
    }

    public function updateAddress(Request $request,$id)
    {
        $address = $this->user->updateAddress($request,$id);

        return $this->response(new UserAddressResource($address));
    }
}
