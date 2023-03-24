<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ForceDeleteRequest;
use App\Http\Requests\Dashboard\MassDestroyRequest;
use App\Http\Requests\Dashboard\MassForceDeleteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use DB;

class ModelDeleteController extends Controller
{
    /**
     * Mass Soft Removal the specified resources from storage.
     */
    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        abort_if(Gate::denies("delete_".$request->slug), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->model::whereIn('id', $request->ids)->delete();

        return Response()->json(['message'=>'Selected Records Deleted Successfully']);
    }

    /**
     * Remove the specified resource from storage permanently.
     */
    public function forceDelete(ForceDeleteRequest $request): JsonResponse
    {
        abort_if(Gate::denies("forceDelete_".$request->slug), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::table($request->slug)->where('id', $request->id)->delete();

        return Response()->json(['message'=>'Selected Record Deleted Permanently']);
    }

    /**
     * Mass Remove the specified resources from storage permanently.
     */

    public function massForceDelete(MassForceDeleteRequest $request): JsonResponse
    {
        abort_if(Gate::denies("forceDelete_".$request->slug), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::table($request->slug)->whereIn('id', $request->ids)->delete();

        return Response()->json(['message'=>'Selected Records Deleted Permanently']);
    }
}
