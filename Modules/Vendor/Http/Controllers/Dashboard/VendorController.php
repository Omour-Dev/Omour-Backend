<?php

namespace Modules\Vendor\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Core\Traits\DataTable;
use Modules\Vendor\Http\Requests\Dashboard\VendorRequest;
use Modules\Vendor\Transformers\Dashboard\VendorResource;
use Modules\Vendor\Repositories\Dashboard\VendorRepository as Vendor;
use Modules\User\Repositories\Dashboard\VendorRepository as Seller;

class VendorController extends Controller
{

    function __construct(Vendor $vendor,Seller $seller)
    {
        $this->seller = $seller;
        $this->vendor = $vendor;
    }

    public function index()
    {
        return view('vendor::dashboard.vendors.index');
    }

    public function sorting()
    {
        $vendors = $this->vendor->getAll('sorting','ASC');
        return view('vendor::dashboard.vendors.sorting',compact('vendors'));
    }

    public function storeSorting(Request $request)
    {
        $create = $this->vendor->sorting($request);

        if ($create) {
          return Response()->json([true , __('apps::dashboard.messages.created')]);
        }

        return Response()->json([false  , __('apps::dashboard.messages.failed')]);
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->vendor->QueryTable($request));

        $datatable['data'] = VendorResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $sellers = $this->seller->getAllVendors();

        return view('vendor::dashboard.vendors.create',compact('sellers'));
    }

    public function store(VendorRequest $request)
    {

        try {
            $create = $this->vendor->create($request);

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
        abort(404);
        return view('vendor::dashboard.vendors.show');
    }

    public function edit($id)
    {
        $sellers = $this->seller->getAllVendors();

        $vendor = $this->vendor->findById($id);

        return view('vendor::dashboard.vendors.edit',compact('vendor','sellers'));
    }

    public function update(VendorRequest $request, $id)
    {
        try {
            $update = $this->vendor->update($request,$id);

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
            $delete = $this->vendor->delete($id);

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
            $deleteSelected = $this->vendor->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
