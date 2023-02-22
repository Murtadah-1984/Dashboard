<?php

namespace App\Http\Controllers;

use App\Charts\StatusChart;
use App\Http\Requests\Store\StoreStatusRequest;
use App\Http\Requests\Update\UpdateStatusRequest;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StatusController extends Controller
{
     /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Status::class, "Status");
    }
    /**
     * Display a listing of the resource.
     */
    public function index(StatusChart $chart): Response
    {
        $Statuss=Status::withTrashed()->get();
        return view('Statuses.index',compact('chart','Statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request): RedirectResponse
    {
        $Status=Status::create($request->all());
        return redirect()->route('Statuses.index')->with('message','Status Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status): Response
    {
        $Status=Status::withTrashed()->find($status);
        return Response::json($Status);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status): Response
    {
        $Status=Status::withTrashed()->find($status);
        return Response::json($Status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status): RedirectResponse
    {
        $status->update($request->all());
        return redirect()->route('Statuses.index')->with('message','Status Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status): RedirectResponse
    {
        $status->delete();
        return back()->with('message','Status is Deleted Successfully');
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore(Status $status): RedirectResponse
    {
        Status ::withTrashed()->find($status)->restore();
        return redirect()->route('Statuses.index')->with('message','Status Restored Successfully');
    }
}
