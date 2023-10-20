<?php

namespace Modules\Page\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Page\Http\Requests\Dashboard\PageRequest;
use Modules\Page\Transformers\Dashboard\PageResource;
use Modules\Page\Repositories\Dashboard\PageRepository as Page;

class PageController extends Controller
{

    function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function index()
    {
        return view('page::dashboard.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->page->QueryTable($request));

        $datatable['data'] = PageResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('page::dashboard.create');
    }

    public function store(PageRequest $request)
    {
        try {
            $create = $this->page->create($request);

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
        return view('page::dashboard.show');
    }

    public function edit($id)
    {
        $page = $this->page->findById($id);

        return view('page::dashboard.edit',compact('page'));
    }

    public function update(PageRequest $request, $id)
    {
        try {
            $update = $this->page->update($request,$id);

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
            $delete = $this->page->delete($id);

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
            $deleteSelected = $this->page->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
