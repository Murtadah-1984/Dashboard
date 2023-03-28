<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\DashboardBaseController;
use App\Http\Requests\Store\StoreRoleRequest;
use App\Http\Requests\Update\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolesApiController extends DashboardBaseController
{
    public function index()
    {
        abort_if(Gate::denies('browse_roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RoleResource(Role::with(['permissions'])->get());
    }

    public function store(StoreRoleRequest $request)
    {
        abort_if(Gate::denies('add_roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        return (new RoleResource($role))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Role $role)
    {
        abort_if(Gate::denies('read_roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RoleResource($role->load(['permissions']));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        abort_if(Gate::denies('edit_roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        return (new RoleResource($role))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('delete_roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
