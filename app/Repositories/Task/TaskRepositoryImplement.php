<?php

namespace App\Repositories\Task;

use App\Models\Report;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Task;

class TaskRepositoryImplement implements TaskRepository
{

    public function __construct(
        protected Task $model
    ) {}

    public function create(array $data, ?Report $report): void
    {
        $task = new $this->model($data);
        $report->tasks()->save($task);
    }
}
