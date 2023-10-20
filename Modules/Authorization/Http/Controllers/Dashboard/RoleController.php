<?php

namespace Modules\Authorization\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Authorization\Entities\Role;
use Modules\Authorization\Http\Requests\Dashboard\RoleRequest;
use Modules\Authorization\Transformers\Dashboard\RoleResource;
use Modules\Authorization\Repositories\Dashboard\RoleRepository;
use Modules\Authorization\Repositories\Dashboard\PermissionRepository as Permission;

class RoleController extends Controller
{
    public $role;
    public $permission;
    public function __construct(RoleRepository $role, Permission $permission)
    {
        $this->permission = $permission;
        $this->role       = $role;
    }

    public function index()
    {
        return view('authorization::dashboard.roles.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->role->QueryTable($request));

        $datatable['data'] = RoleResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $permissions = $this->permission->getAll('id', 'asc');
        return view('authorization::dashboard.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        try {
            $create = $this->role->create($request);

            if ($create) {
                return Response()->json([true, __('apps::dashboard.messages.created')]);
            }

            return Response()->json([true, __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('authorization::dashboard.roles.show');
    }

    public function edit($id)
    {
        $role = $this->role->findById($id);
        $permissions = $this->permission->getAll('id', 'asc');

        return view('authorization::dashboard.roles.edit', compact('role', 'permissions'));
    }

    public function update(RoleRequest $request, $id)
    {
        try {
            $update = $this->role->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([true, __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $roleUsers = User::whereHas('roles', function ($q) use ($id) {
                return  $q->where('id', $id);
            })->count();
            if ($roleUsers > 0) {
                return Response()->json([false, __('authorization::dashboard.roles.role_has_users')]);
            }
            $delete = $this->role->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true, __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {

            $roleUsers = User::whereHas('roles', function ($q) use ($request) {
                return  $q->whereIn('id', $request['ids']);
            })->count();
            if ($roleUsers > 0) {
                return Response()->json([false, __('authorization::dashboard.roles.role_has_users')]);
            }
            $deleteSelected = $this->role->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true, __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
