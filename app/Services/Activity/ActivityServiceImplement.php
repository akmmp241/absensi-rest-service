<?php

namespace App\Services\Activity;

use App\Exceptions\FailedCreateActivityException;
use App\Repositories\Report\ReportRepository;
use App\Repositories\Task\TaskRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;
use Symfony\Component\HttpFoundation\Response;

class ActivityServiceImplement extends Service implements ActivityService
{
    public function __construct(
        protected ReportRepository $reportRepository,
        protected TaskRepository   $taskRepository
    ){}

    /**
     * @throws FailedCreateActivityException
     */
    public function createNewActivity(array $data): void
    {
        $report = $this->reportRepository->getByDate($data['date'], $data['student_id']);

        if (!$report) {
            if ($data['type'] === "keluar") {
                throw new FailedCreateActivityException('Anda belum melakukan absensi masuk', Response::HTTP_NOT_FOUND);
            } else {
                $this->createActivity($data, false);
                return;
            }
        }

        if ($data['type'] === "masuk") {
            throw new FailedCreateActivityException('Anda sudah melakukan absensi masuk', Response::HTTP_EXPECTATION_FAILED);
        }

        if ($report->tasks()->count() >= 2) {
            throw new FailedCreateActivityException('Anda sudah melakukan absensi keluar', Response::HTTP_EXPECTATION_FAILED);
        }

        $data['report'] = $report;
        $this->createActivity($data, true);
    }

    public function createActivity(array $data, bool $isKeluar): void
    {
        try {
            DB::beginTransaction();

            if (!$isKeluar) {
                $report = $this->reportRepository->create($data);
                $this->taskRepository->create($data, $report);
            } else {
                $this->taskRepository->create($data, $data['report']);
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }

    public function getAllActivity(bool $recent): Collection
    {
        return $this->reportRepository->all($recent);
    }

    public function storeImage(UploadedFile $file): bool|string
    {
        return $file->store('images');
    }

    public function filterActivityByStatus($reports, $status): Collection
    {
        return $reports->filter(function ($report) use ($status) {
            return $report->tasks->filter(function ($task) use ($status) {
                    return $task->status === $status;
                })->count() > 0;
        });
    }
}
