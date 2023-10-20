<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\User\Http\Requests\Dashboard\VendorRequest;
use Modules\User\Transformers\Dashboard\VendorResource;
use Modules\User\Repositories\Dashboard\VendorRepository as Vendor;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class VendorController extends Controller
{

    function __construct(Vendor $admin , Role $role)
    {
        $this->role = $role;
        $this->admin = $admin;
    }

    public function index()
    {
        return view('user::dashboard.vendors.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->admin->QueryTable($request));

        $datatable['data'] = VendorResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $roles = $this->role->getAllVendorsRoles('id','asc');
        return view('user::dashboard.vendors.create',compact('roles'));
    }

    public function store(VendorRequest $request)
    {
        try {
            $create = $this->admin->create($request);

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
        return view('user::dashboard.vendors.show');
    }

    public function edit($id)
    {
        $user = $this->admin->findById($id);
        $roles = $this->role->getAllVendorsRoles('id','asc');

        return view('user::dashboard.vendors.edit',compact('user','roles'));
    }

    public function update(VendorRequest $request, $id)
    {
        try {
            $update = $this->admin->update($request,$id);

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
            $delete = $this->admin->delete($id);

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
            $deleteSelected = $this->admin->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
