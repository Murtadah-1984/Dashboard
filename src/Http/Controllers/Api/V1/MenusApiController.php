<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\DashboardBaseController;
use App\Http\Requests\Store\StoreMenuRequest;
use App\Http\Requests\Update\UpdateMenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenusApiController extends DashboardBaseController
{
    public function index()
    {
        abort_if(Gate::denies('browse_menus'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MenuResource(Menu::with(['children'])->get());
    }

    public function store(StoreMenuRequest $request)
    {
        abort_if(Gate::denies('add_menus'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menu = Menu::create($request->all());

        return (new MenuResource($menu))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Menu $menu)
    {
        abort_if(Gate::denies('read_menus'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MenuResource($menu->load(['children']));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        abort_if(Gate::denies('edit_menus'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menu->update($request->all());


        return (new MenuResource($menu))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Menu $menu)
    {
        abort_if(Gate::denies('delete_menus'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menu->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
