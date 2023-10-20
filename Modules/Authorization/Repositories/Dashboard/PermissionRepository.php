<?php

namespace Modules\Authorization\Repositories\Dashboard;

use Modules\Authorization\Entities\Permission;
use Lang;
use DB;

class PermissionRepository
{
    function __construct(Permission $permission)
    {
        $this->permission  = $permission;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $permissions = $this->permission->with('translations')->orderBy($order, $sort)->get();
        return $permissions;
    }

    public function findById($id)
    {
        try {

            $permission = $this->permission->findOrFail($id);
            return $permission;
        } catch (\Exception $e) {

            return abort(404);
        }
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['permission'] as $permission) {

                $model = $this->permission->create([
                    'name'                => $permission . '_' . $request['display_name'],
                    'display_name'        => $request['display_name'],
                ]);

                $this->translateTable($model, $permission);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function translateDescription($permission, $code)
    {
        switch ($permission) {
            case 'add':
                $description =  Lang::get('authorization::dashboard.permissions.form.add', [], $code);
                break;
            case 'delete':
                $description =  Lang::get('authorization::dashboard.permissions.form.delete', [], $code);
                break;
            case 'show':
                $description =  Lang::get('authorization::dashboard.permissions.form.show', [], $code);
                break;
            case 'edit':
                $description =  Lang::get('authorization::dashboard.permissions.form.edit', [], $code);
                break;
            default:
                $description =  Lang::get('authorization::dashboard.permissions.form.create', [], $code);
                break;
        }

        return $description;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        try {

            $perm = $this->findById($id);

            $perm->update([
                'name'                => $request->name,
                'display_name'        => $request->display_name,
            ]);

            foreach ($request['description'] as $locale => $value) {
                $perm->translateOrNew($locale)->description = $value;
            }

            $perm->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw false;
        }
    }

    public function translateTable($model, $request)
    {
        foreach (config('translatable.locales') as $locale) {

            $description = $this->translateDescription($request, $locale);

            $model->translateOrNew($locale)->description = $description;
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $this->findById($id)->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return true;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            $this->permission->destroy($request['ids']);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->permission->with(['translations'])->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('display_name', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('name', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('description', 'like', '%' . $request->input('search.value') . '%');
                });
            });
        });

        $query = self::filterDataTable($query, $request);

        return $query;
    }

    public static function filterDataTable($query, $request)
    {
        // Search Users by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        return $query;
    }
}
