<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Permission;
use App\Http\Requests\Permission\StoreRequest;
use App\Http\Requests\Permission\UpdateRequest;
use Illuminate\Support\Facades\Gate;



class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('browse_permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(request()->ajax()) {
            if (request()->has('scope')) {
                $scopeName = request()->input('scope');
                $permissions=Permission::withTrashed()->with('roles:id,display_name')->$scopeName();
            }else{
                $permissions=Permission::withTrashed()->with('roles:id,display_name');
            }
            return dataTables($permissions)
                ->addColumn('checkbox', function($data){
                    return '<input type="checkbox"  class="checkbox" value="'.$data->id.'" name="checkbox[]" data-id="'.$data->id.'" >';
                })
                ->addColumn('action', function($data){
                    return view('permissions.action', compact('data'));
                })
                ->rawColumns(['action','checkbox'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('permissions.index');
    }

    /**
     * Create a list that will be used for listing users.
     */
    public function create(): JsonResponse
    {
        if (request()->has('scopes')) {
            // Get the global scopes defined on the Vendor model
            return Response()->json($this->getModelScopes('Permission'));
        }
        elseif(request()->has('q')){
            $search = request()->q;
            $permissions =Permission::select("id","key as text")
                ->where('key','LIKE',"%$search%")
                ->get()
                ->toArray();
        }else {
            $permissions = Permission::select("id","key as text")
                ->get()->toArray();
        }

        return Response()->json($permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        abort_if(Gate::denies('add_permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($request->filled('id'))
        {
            $request=app(UpdateRequest::class);
            $permission=Permission::find($request->id);
            $permission->update([
                "key"=>$request->key,
                "table_name"=>$request->table_name,
            ]);
            $message= $permission->key." Updated Successfully";

        }
        else{
            $request=app(StoreRequest::class);
            $permission=Permission::create([
                "key"=>$request->key,
                "table_name"=>$request->table_name,
            ]);
            $message= $permission->name." Created Successfully";
        }


        return Response()->json(['message'=>$message]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission): JsonResponse
    {
        abort_if(Gate::denies('read_permissions'), JsonResponse::HTTP_FORBIDDEN, '403 Forbidden');

        return response()->json(Permission::with('roles:id,display_name')->find($permission->id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission): JsonResponse
    {
        abort_if(Gate::denies('edit_permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Response()->json(Permission::with('roles:id,display_name')->find($permission->id));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): JsonResponse
    {
        abort_if(Gate::denies('delete_permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->delete();

        $message= $permission->key." Deleted Successfully";

        return Response()->json(['message'=>$message]);
    }

}

