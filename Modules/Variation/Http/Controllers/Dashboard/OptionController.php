<?php

namespace Modules\Variation\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Variation\Http\Requests\Dashboard\OptionRequest;
use Modules\Variation\Transformers\Dashboard\OptionResource;
use Modules\Variation\Repositories\Dashboard\OptionRepository as Option;

class OptionController extends Controller
{

    function __construct(Option $option)
    {
        $this->option = $option;
    }

    public function optionByVendor(Request $request)
    {
        $options = $this->option->findOptionByVendor($request['vendor_id']);

        return view('product::dashboard.products.html.variations',compact('options'));
    }

    public function index()
    {
        return view('variation::dashboard.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->option->QueryTable($request));

        $datatable['data'] = OptionResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('variation::dashboard.create');
    }

    public function store(OptionRequest $request)
    {
        try {
            $create = $this->option->create($request);

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
        return view('variation::dashboard.show');
    }

    public function edit($id)
    {
        $option = $this->option->findById($id);

        return view('variation::dashboard.edit',compact('option'));
    }

    public function update(OptionRequest $request, $id)
    {
        try {
            $update = $this->option->update($request,$id);

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
            $delete = $this->option->delete($id);

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
            $deleteSelected = $this->option->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
