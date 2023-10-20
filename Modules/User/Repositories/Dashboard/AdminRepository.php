<?php

namespace Modules\User\Repositories\Dashboard;

use DB;
use Hash;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminRepository
{
    use SoftDeletes;

    protected $table = 'users';
    protected $user;

    function __construct(User $user)
    {
        $this->user      = $user;
    }

    /*
    * Get All Normal Users with Admin Roles
    */
    public function getAllAdmins($order = 'id', $sort = 'desc')
    {
        $users = $this->user->whereHas('roles.perms', function ($query) {
            $query->where('name', 'dashboard_access');
        })->orderBy($order, $sort)->get();
        return $users;
    }

    /*
    * Find Object By ID
    */
    public function findById($id)
    {
        $user = $this->user->withDeleted()->find($id);
        return $user;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $user = $this->user->where('email', $email)->first();
        return $user;
    }


    /*
    * Create New Object & Insert to DB
    */
    public function create($request)
    {
        DB::beginTransaction();

        try {

            $image = $request['image'] ? path_without_domain($request['image']) : '/uploads/users/user.png';

            $user = $this->user->create([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'password'      => Hash::make($request['password']),
                'image'         => $image,
            ]);

            if ($request['roles'] != null)
                $this->saveRoles($user, $request);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function saveRoles($user, $request)
    {
        foreach ($request['roles'] as $key => $value) {
            $user->attachRole($value);
        }

        return true;
    }

    /*
    * Find Object By ID & Update to DB
    */
    public function update($request, $id)
    {
        DB::beginTransaction();

        $user = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($user) : null;

        try {

            $image = $request['image'] ? path_without_domain($request['image']) : $user->image;

            if ($request['password'] == null)
                $password = $user['password'];
            else
                $password  = Hash::make($request['password']);

            $user->update([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'password'      => $password,
                'image'         => $image,
            ]);

            if ($request['roles'] != null) {
                DB::table('role_user')->where('user_id', $id)->delete();

                foreach ($request['roles'] as $key => $value) {
                    $user->attachRole($value);
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()) :
                $model->forceDelete();
            else :
                $model->delete();
            endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Find all Objects By IDs & Delete it from DB
    */
    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Generate Datatable
    */



    public function queryTable($request)
    {
        $query = $this->user->whereHas('roles.perms', function ($query) {
            $query->where('name', 'dashboard_access');
        })->with('roles.perms')->where('id', '!=', auth()->id());

        $searchValue = $request->input('search.value');
        $query->where(function ($query) use ($searchValue) {
            $query->where('id', 'like', "%$searchValue%")
                ->orWhere('name', 'like', "%$searchValue%")
                ->orWhere('email', 'like', "%$searchValue%")
                ->orWhere('mobile', 'like', "%$searchValue%");
        });



        $query->orWhereHas('roles', function ($query) use ($searchValue) {
            $query->where('name', 'like', "%$searchValue%");
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }


    public function filterDataTable($query, $request)
    {
        $deleted = $request->input('req.deleted', 'all');

        $query
            ->when(!empty($request->input('req.from')), function ($query) use ($request) {
                $query->where('created_at', '>=', $request->input('req.from'));
            })
            ->when(!empty($request->input('req.to')), function ($query) use ($request) {
                $query->where('created_at', '<=', $request->input('req.to'));
            })
            ->when(!empty($request->input('req.roles')), function ($query) use ($request) {
                $query->whereHas('roles', function ($query) use ($request) {
                    $query->where('id', $request->input('req.roles'));
                });
            })
            ->when($deleted === 'only', function ($query) {
                $query->onlyDeleted();
            })
            ->when($deleted === 'with', function ($query) {
                $query->withTrashed();
            })
            ->when($deleted === 'not_deleted', function ($query) {
                $query->whereNull('deleted_at');
            });

        return $query;
    }
}
