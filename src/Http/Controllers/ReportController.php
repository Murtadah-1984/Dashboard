<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ReportController extends DashboardBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('browse_reports'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(request()->ajax()) {
            if (request()->has('scope')) {
                $scopeName = request()->input('scope');
                $reports=Report::query()->$scopeName();
            }else{
                $reports=Report::query();
            }
            return dataTables($reports)
                ->addIndexColumn()
                ->make(true);
        }

        return view('settings.reports.index');
    }

    public function create()
    {
        if (request()->has('scopes')) {
            // Get the global scopes defined on the Vendor model
            return Response()->json($this->getModelScopes('Report'));
        }
        elseif(request()->has('q')){
            $search = request()->q;
            $report =Report::select("id","user as text")
                ->where('user','LIKE',"%$search%")
                ->get()
                ->toArray();
        }else{
            $report = Report::select("id","user as text")
                ->get()->toArray();
        }

        return Response()->json($report);
    }
}
