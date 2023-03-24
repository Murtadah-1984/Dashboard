<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MassRestoreRequest;
use App\Http\Requests\Dashboard\RestoreRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ModelRestoreController extends Controller
{
    /**
     * Restore the specified resource from storage.
     */
    public function restore(RestoreRequest $request): JsonResponse
    {
        abort_if(Gate::denies('restore_'.$request->slug), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->model::onlyTrashed()->find($request->id)->restore();

        $message="Selected Record Restored Successfully";

        return Response()->json(['message'=>$message]);
    }

    /**
     * Mass restore the specified resources from storage.
     */

    public function massRestore(MassRestoreRequest $request): JsonResponse
    {
        abort_if(Gate::denies('restore_'.$request->slug), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->model::onlyTrashed()->whereIn('id',$request->ids)->restore();

        $message="Selected Records Restored Successfully";

        return Response()->json(['message'=>$message]);
    }
}
