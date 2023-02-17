<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Permission;

class PermissionController extends Controller
{
     /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Permission::class, 'permission');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $permissions = Permission::all();
        return view('users.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('users.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $permission = Permission::create($request->all());

        return redirect()->route('users.permissions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission): Response
    {
        return view('frontend.users.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission): Response
    {
        return view('users.permissions.edit', compact('permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $permission->update($request->all());

        return redirect()->route('users.permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();

        return back();
    }
}

