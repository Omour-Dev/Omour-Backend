<?php

namespace Modules\Product\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Product\Http\Requests\Dashboard\ProductRequest;
use Modules\Product\Transformers\Dashboard\ProductResource;
use Modules\Product\Repositories\Dashboard\ProductRepository as Product;

class ProductController extends Controller
{

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        return view('product::dashboard.products.index');
    }

    public function reports()
    {
        return view('product::dashboard.products.reports');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->product->QueryTable($request));

        $datatable['data'] = ProductResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('product::dashboard.products.create');
    }

    public function store(ProductRequest $request)
    {
        try {
            $create = $this->product->create($request);

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
        return view('product::dashboard.products.show');
    }

    public function edit($id)
    {
        $product = $this->product->findById($id);

        return view('product::dashboard.products.edit',compact('product'));
    }

    public function clone($id)
    {
        $product = $this->product->findById($id);

        return view('product::dashboard.products.clone',compact('product'));
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $update = $this->product->update($request,$id);

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
            $delete = $this->product->delete($id);

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
            $deleteSelected = $this->product->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
