<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Role;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;
use Illuminate\Support\Facades\Gate;



class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('browse_roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(request()->ajax()) {
            if (request()->has('scope')) {
                $scopeName = request()->input('scope');
                $roles=Role::withTrashed()->with('permissions:id,key')->$scopeName();
            }else{
                $roles=Role::withTrashed()->with('permissions:id,key');
            }
            return dataTables($roles)
                ->addColumn('checkbox', function($data){
                    return '<input type="checkbox"  class="checkbox" value="'.$data->id.'" name="checkbox[]" data-id="'.$data->id.'" >';
                })
                ->addColumn('action', function($data){
                    return view('roles.action', compact('data'));
                })
                ->rawColumns(['action','checkbox'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('roles.index');
    }

    /**
     * Create a list that will be used for listing users.
     */
    public function create(): JsonResponse
    {
        if (request()->has('scopes')) {
            // Get the global scopes defined on the Vendor model
            return Response()->json($this->getModelScopes('Role'));
        }
        if(request()->has('q')){
            $search = request()->q;
            $roles =Role::select("id","display_name as text")
                ->where('name','LIKE',"%$search%")
                ->get()
                ->toArray();
        }else{
            $roles = Role::select("id","display_name as text")
                ->get()->toArray();
        }

        return Response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        abort_if(Gate::denies('add_roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($request->filled('id'))
        {
            $request=app(UpdateRequest::class);
            $role=Role::find($request->id);
            $role->update([
                "name"=>$request->name,
                "display_name"=>$request->display_name,
            ]);
            $message= $role->name." Updated Successfully";

        }
        else{
            $request=app(StoreRequest::class);
            $role=Role::create([
                "name"=>$request->name,
                "display_name"=>$request->display_name,
            ]);
            $message= $role->name." Created Successfully";
        }

        $role->permissions()->sync($request->input('permissions', []));

        return Response()->json(['message'=>$message]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): JsonResponse
    {
        abort_if(Gate::denies('read_roles'), JsonResponse::HTTP_FORBIDDEN, '403 Forbidden');

        return response()->json(Role::with('permissions:id,key')->find($role->id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): JsonResponse
    {
        abort_if(Gate::denies('edit_roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Response()->json(Role::with('permissions:id,key,table_name')->find($role->id));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): JsonResponse
    {
        abort_if(Gate::denies('delete_roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->delete();

        $message= $role->name." Deleted Successfully";

        return Response()->json(['message'=>$message]);
    }

}

