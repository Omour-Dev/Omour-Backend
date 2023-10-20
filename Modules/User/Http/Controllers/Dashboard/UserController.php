<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\User\Http\Requests\Dashboard\UserRequest;
use Modules\User\Transformers\Dashboard\UserResource;
use Modules\User\Repositories\Dashboard\UserRepository as User;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class UserController extends Controller
{

    function __construct(User $user , Role $role)
    {
        $this->role = $role;
        $this->user = $user;
    }

    public function index()
    {
        return view('user::dashboard.users.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->user->QueryTable($request));

        $datatable['data'] = UserResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $roles = $this->role->getAll('id','asc');
        return view('user::dashboard.users.create',compact('roles'));
    }

    public function store(UserRequest $request)
    {
        try {
            $create = $this->user->create($request);

            if ($create) {
              return Response()->json([true , __('apps::dashboard.messages.created')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        abort(404);
        return view('user::dashboard.users.show');
    }

    public function edit($id)
    {
        $user = $this->user->findById($id);
        $roles = $this->role->getAll('id','asc');

        return view('user::dashboard.users.edit',compact('user','roles'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $update = $this->user->update($request,$id);

            if ($update) {
              return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->user->delete($id);

            if ($delete) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->user->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
