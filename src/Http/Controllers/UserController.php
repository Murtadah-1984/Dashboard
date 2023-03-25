<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Support\Facades\Gate;



class UserController extends DashboardBaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if user is authorized to browse users, otherwise abort with 403 Forbidden
        abort_if(Gate::denies('browse_users'), 403, response()->json(['message' => 'You are not authorized to browse users'], 403));
        // Define the columns to be displayed in the DataTable
        $columns=json_encode(['name','email','role','roles']);

        // If the request is made through AJAX, retrieve the users data and return it as a JSON response
        if(request()->ajax()) {
            if (request()->has('scope')) {
                $scopeName = request()->input('scope');
                $users=User::withTrashed()->with(['role:id,display_name', 'roles:id,display_name'])->$scopeName();
            }else{
                $users=User::withTrashed()->with(['role:id,display_name', 'roles:id,display_name']);
            }
            return dataTables($users)
                ->addColumn('checkbox', function($data){
                    return '<input type="checkbox"  class="checkbox" value="'.$data->id.'" name="checkbox[]" data-id="'.$data->id.'" >';
                })
                ->addColumn('role', function ($item) {
                    return $item->role->display_name;
                })
                ->addColumn('roles', function ($item) {
                    return $item->roles->pluck('display_name')->implode('<br>');
                })
                ->addColumn('action', function($data){
                    return view('users.action', compact('data'));
                })
                ->rawColumns(['action','checkbox','role','roles'])
                ->addIndexColumn()
                ->make(true);
        }
        // If the request is not made through AJAX, return a view that renders the DataTable
        return view('users.index',compact('columns'));
    }

    /**
     * Create a list that will be used for listing users.
     */
    public function create(): JsonResponse
    {
        if (request()->has('scopes')) {
            // Get the global scopes defined on the Vendor model
            return Response()->json($this->getModelScopes('User'));
        }else if(request()->has('q'))
        {
            $search = request()->q;
            $users = User::select("id", "name as text")
                ->where('name', 'LIKE', "%$search%")
                ->get()
                ->toArray();
        }else
        {
            $users=User::select("id","name as text")
                ->get()->toArray();
        }
        return Response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        abort_if(Gate::denies('add_users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($request->filled('id'))
        {
            $request=app(UpdateRequest::class);
            $user=User::find($request->id);
            $user->update([
                "name"=>$request->name,
                "email"=>$request->email,
                "role_id"=>$request->role_id,
            ]);
            $message= $user->name." Updated Successfully";

        }else
        {
            $request=app(StoreRequest::class);
            $user=User::create([
                "name"=>$request->name,
                "email"=>$request->email,
                "role_id"=>$request->role_id,
                'password' => Hash::make($request->password)
            ]);
            $message= $user->name." Created Successfully";
           
        }


        $user->roles()->sync($request->input('roles', []));
        return Response()->json(['message'=>$message]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        abort_if(Gate::denies('read_users'), JsonResponse::HTTP_FORBIDDEN, '403 Forbidden');

        return response()->json(User::with(['role:id,display_name', 'roles:id,display_name'])->find($user->id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): JsonResponse
    {
        abort_if(Gate::denies('edit_users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Response()->json(User::with(['role:id,display_name', 'roles:id,display_name'])->find($user->id));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        abort_if(Gate::denies('delete_users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        $message= $user->name." Deleted Successfully";

        return Response()->json(['message'=>$message]);
    }


    public function disable(User $user): JsonResponse
    {

        $user->disable();

        $message= $user->name." Disabled Successfully";

        return Response()->json(['message'=>$message]);
    }

    public function changePassword(User $user, Request $request): JsonResponse
    {

        $user->setPassword($request->password);

        $message="Password for ". $user->name." Update Successfully";

        return Response()->json(['message'=>$message]);
    }
}

