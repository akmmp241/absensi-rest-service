<?php

namespace App\Repositories\Report;

use App\Models\Report;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ReportRepositoryImplement implements ReportRepository
{
    public function __construct(
        protected Report $model
    ) {}

    public function getByDate(string $date, int $student_id): Report|Model
    {
        return $this->model::query()->whereDate('date', $date)
            ->where('student_id', $student_id)
            ->first();
    }

    public function create(array $data): Report
    {
        $report = new $this->model($data);
        $report->save();

        return $report;
    }

    public function all(bool $recent): Collection
    {
        $reports = $this->model::query()->with(['tasks', 'student', 'dudi'])
            ->where('student_id', Auth::id());

        return $recent ? $reports->recent()->get() : $reports->get();
    }
}
