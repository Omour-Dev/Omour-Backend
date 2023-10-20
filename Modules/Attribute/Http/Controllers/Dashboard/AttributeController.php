<?php

namespace Modules\Attribute\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Attribute\Http\Requests\Dashboard\AttributeRequest;
use Modules\Attribute\Transformers\Dashboard\AttributeResource;
use Modules\Attribute\Repositories\Dashboard\AttributeRepository as Attribute;

class AttributeController extends Controller
{

    function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function attributeByVendor(Request $request)
    {
        $attributes = $this->attribute->findAttributeByVendor($request['vendor_id']);

        return view('product::dashboard.products.html.attributes',compact('attributes'));
    }

    public function index()
    {
        return view('attribute::dashboard.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->attribute->QueryTable($request));

        $datatable['data'] = AttributeResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('attribute::dashboard.create');
    }

    public function store(AttributeRequest $request)
    {
        try {
            $create = $this->attribute->create($request);

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
        return view('attribute::dashboard.show');
    }

    public function edit($id)
    {
        $attribute = $this->attribute->findById($id);

        return view('attribute::dashboard.edit',compact('attribute'));
    }

    public function update(AttributeRequest $request, $id)
    {
        try {
            $update = $this->attribute->update($request,$id);

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
            $delete = $this->attribute->delete($id);

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
            $deleteSelected = $this->attribute->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
