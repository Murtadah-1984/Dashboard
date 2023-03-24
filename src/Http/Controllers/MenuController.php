<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Menu;
use App\Http\Requests\Menu\StoreRequest;
use App\Http\Requests\Menu\UpdateRequest;
use Illuminate\Support\Facades\Gate;



class MenuController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('browse_menus'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(request()->ajax()) {
            if (request()->has('scope')) {
                $scopeName = request()->input('scope');
                $menus=Menu::withTrashed()->with('parent:id,title')->$scopeName();
            }else{
                $menus=Menu::withTrashed()->with('parent:id,title');
            }
            return dataTables($menus)
                ->addColumn('checkbox', function($data){
                    return '<input type="checkbox"  class="checkbox" value="'.$data->id.'" name="checkbox[]" data-id="'.$data->id.'" >';
                })
                ->addColumn('action', function($data){
                    return view('menus.action', compact('data'));
                })
                ->rawColumns(['action','checkbox'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('menus.index');
    }

    /**
     * Create a list that will be used for listing users.
     */
    public function create(): JsonResponse
    {
        if (request()->has('scopes')) {
            // Get the global scopes defined on the Vendor model
            return Response()->json($this->getModelScopes('Menu'));
        }
        elseif(request()->has('q')){
            $search = request()->q;
            $menu =Menu::select("id","title as text")
                ->where('title','LIKE',"%$search%")
                ->get()
                ->toArray();
        }else{
            $menu = Menu::select("id","title as text")
                ->get()->toArray();
        }

        return Response()->json($menu);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        abort_if(Gate::denies('add_menus'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($request->filled('id'))
        {
            $request=app(UpdateRequest::class);
            $menu=Menu::find($request->id);
            $menu->update([
                "title"=>$request->title,
                "route"=>$request->route,
                "policy"=>$request->policy,
                "class"=>$request->class,
                "parent_id"=>$request->parent_id,
                "order"=>$request->order,
            ]);
            $message= $menu->title." Updated Successfully";

        }
        else{
            $request=app(StoreRequest::class);
            $menu=Menu::create([
                "title"=>$request->title,
                "route"=>$request->route,
                "policy"=>$request->policy,
                "class"=>$request->class,
                "parent_id"=>$request->parent_id,
                "order"=>$request->order,
            ]);
            $message= $menu->title." Created Successfully";
        }
        return Response()->json(['message'=>$message]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu): JsonResponse
    {
        abort_if(Gate::denies('read_menus'), JsonResponse::HTTP_FORBIDDEN, '403 Forbidden');

        return response()->json(Menu::with(['parent:id,title','children'])->find($menu->id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu): JsonResponse
    {
        abort_if(Gate::denies('edit_menus'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Response()->json(Menu::with('parent:id,title')->find($menu->id));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu): JsonResponse
    {
        abort_if(Gate::denies('delete_menus'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menu->delete();

        $message= $menu->title." Deleted Successfully";

        return Response()->json(['message'=>$message]);
    }

}

