<?php

namespace Modules\User\Repositories\Api;

use Modules\User\Entities\UserAddress;
use Modules\User\Entities\User;
use Hash;
use DB;

class UserRepository
{

    function __construct(User $user,UserAddress $address)
    {
        $this->user      = $user;
        $this->address   = $address;
    }

    public function update($request)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {

            $user->update([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function changePassword($request)
    {
        $user = $this->userProfile();

        if ($request['password'] == null)
            $password = $user['password'];
        else
            $password  = Hash::make($request['password']);

        DB::beginTransaction();

        try {

            $user->update([
                'password'      => $password,
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function userProfile()
    {
        return auth()->user();
    }

    public function addresses()
    {
        return $this->address->where('user_id',auth()->id())->get();
    }

    public function addAddress($request)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {

            $address = $user->addresses()->create([
                'username'      => $request['username'],
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'street'        => $request['street'],
                'building'        => $request['building'],
                'floor'        => $request['floor'],
                'door'        => $request['door'],
                'address'        => $request['address'],
                'area_id'        => $request['area_id'],
            ]);

            DB::commit();
            return $address;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function updateAddress($request,$id)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $address = $this->address->find($id);

            $address->update([
                'username'      => $request['username'],
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'street'        => $request['street'],
                'building'        => $request['building'],
                'floor'        => $request['floor'],
                'door'        => $request['door'],
                'address'        => $request['address'],
                'area_id'        => $request['area_id'],
            ]);

            DB::commit();
            return $address;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }
}
