<?php

namespace App\Http\Controllers\API\Activity;

use App\Exceptions\FailedCreateActivityException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\AddActivityRequest;
use App\Http\Resources\ReportsCollection;
use App\Models\Report;
use App\Models\Task;
use App\Models\User;
use App\Services\Activity\ActivityService;
use App\Services\Response\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ActivityController extends Controller
{
    public function __construct(
        protected ActivityService $activityService,
        protected ResponseService $responseService
    ) {}

    public function create(AddActivityRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['image'] = $this->activityService->storeImage($request->file('image'));

        try {
            $this->activityService->createNewActivity($data);
        } catch (FailedCreateActivityException $exception) {
            throw new HttpResponseException(response()->json([
                "data" => [
                    "success" => false,
                    "message" => $exception->getMessage()
                ]
            ], $exception->getCode()));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new HttpResponseException(response()->json([
                "data" => [
                    "success" => false,
                    "message" => "Failed to insert data"
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        return response()->json([
            "data" => [
                "success" => true,
                "message" => "Success add new Activity"
            ]
        ], Response::HTTP_CREATED);
    }

    public function all(Request $request): JsonResponse
    {
        if (Auth::user()->role_id !== User::$STUDENT) {
            throw new HttpResponseException(response()->json([
                "data" => [
                    "success" => false,
                    "message" => "This action only can be done by student"
                ]
            ]));
        }

        $isRecent = $request->has('recent') && $request->get('recent') == true;

        $reports = $this->activityService->getAllActivity($isRecent);

        if ($request->has('status') && in_array($request->status, ["unconfirmed", "confirmed"])) {
            $reports = $this->activityService->filterActivityByStatus($reports, $request->status);
        }

        return response()->json([
            "data" => [
                "success" => true,
                "message" => "Success to get data",
                "reports" => new ReportsCollection($reports)
            ]
        ], Response::HTTP_OK);
    }
}
