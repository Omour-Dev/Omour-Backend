<?php

namespace Modules\Area\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Area\Http\Requests\Dashboard\AreaRequest;
use Modules\Area\Transformers\Dashboard\AreaResource;
use Modules\Area\Repositories\Dashboard\AreaRepository as Area;

class AreaController extends Controller
{

    function __construct(Area $area)
    {
        $this->area = $area;
    }

    public function index()
    {
        return view('area::dashboard.areas.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->area->QueryTable($request));

        $datatable['data'] = AreaResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('area::dashboard.areas.create');
    }

    public function store(AreaRequest $request)
    {
        try {
            $create = $this->area->create($request);

            if ($create) {
                return Response()->json([true , __('apps::dashboard.messages.created')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('area::dashboard.areas.show');
    }

    public function edit($id)
    {
        $area = $this->area->findById($id);

        return view('area::dashboard.areas.edit',compact('area'));
    }

    public function update(AreaRequest $request, $id)
    {
        try {
            $update = $this->area->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->area->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->area->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
