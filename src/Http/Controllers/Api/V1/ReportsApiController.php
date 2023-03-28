<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\DashboardBaseController;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportsApiController extends DashboardBaseController
{
    public function index()
    {
        abort_if(Gate::denies('browse_reports'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReportResource(Report::all());
    }

    public function store(Request $request)
    {
        //
    }

    public function show()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
