<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\DashboardBaseController;
use App\Http\Requests\Store\StorePermissionRequest;
use App\Http\Requests\Update\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionsApiController extends DashboardBaseController
{
    public function index()
    {
        abort_if(Gate::denies('browse_permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PermissionResource(Permission::all());
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->all());

        return (new PermissionResource($permission))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('read_permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PermissionResource($permission);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        abort_if(Gate::denies('edit_permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->update($request->all());

        return (new PermissionResource($permission))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('delete_permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
