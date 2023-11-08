<?php

namespace App\Http\Controllers\API\Activity;

use App\Exceptions\FailedCreateActivityException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\AddActivityRequest;
use App\Http\Resources\ReportsCollection;
use App\Models\Report;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ActivityController extends Controller
{
    public function create(AddActivityRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['image'] = $request->file('image')->store('images');

        try {

            $report = Report::query()->whereDate('date', $data['date'])
                ->where('student_id', $data['student_id'])
                ->first();

            if (!$report) {
                if ($data['type'] === "masuk") {
                    try {
                        DB::beginTransaction();
                        $report = new Report($data);
                        $report->save();

                        $task = new Task($data);
                        $report->tasks()->save($task);
                        DB::commit();
                    } catch (\Exception $exception) {
                        DB::rollBack();
                    }
                } else {
                    throw new FailedCreateActivityException('Anda belum melakukan absensi masuk', Response::HTTP_NOT_FOUND);
                }
            } else {
                if ($data['type'] === "masuk") {
                    throw new FailedCreateActivityException('Anda sudah melakukan absensi masuk', Response::HTTP_EXPECTATION_FAILED);
                } else {
                    if ($report->tasks->count() === 2) {
                        throw new FailedCreateActivityException('Anda sudah melakukan absensi keluar', Response::HTTP_EXPECTATION_FAILED);
                    }
                    try {
                        DB::beginTransaction();
                        $task = new Task($data);
                        $report->tasks()->save($task);
                        DB::commit();
                    } catch (\Exception $exception) {
                        DB::rollBack();
                    }
                }
            }
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

        $reports = Report::query()->with(['tasks', 'student', 'dudi'])
            ->where('student_id', Auth::id());

        $reports = $request->has('recent') && $request->get('recent') === "true"
            ? $reports->recent()->get() : $reports->get();

        if ($request->has('status') && in_array($request->status, ["unconfirmed", "confirmed"])) {
            $reports = $reports->filter(function ($report) use ($request) {
                return $report->tasks->filter(function ($task) use ($request) {
                        return $task->status === $request->status;
                    })->count() > 0;
            });
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
