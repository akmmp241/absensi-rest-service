<?php

namespace App\Http\Controllers\API\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\AddActivityRequest;
use App\Models\Report;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ActivityController extends Controller
{
    public function create(AddActivityRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['date'] = $data['date'] . ' ' . now()->format('H:i:s');
        $data['image'] = $request->file('image')->store('public/images');

        try {
            DB::beginTransaction();
            $report = new Report($data);
            $report->save();

            $task = new Task($data);
            $report->tasks()->save($task);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                "data" => [
                    "success" => false,
                    "message" => "Failed to insert data"
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "data" => [
                "success" => true,
                "message" => "Success to insert data"
            ]
        ], Response::HTTP_CREATED);
    }
}
