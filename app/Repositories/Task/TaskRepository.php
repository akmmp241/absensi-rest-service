<?php

namespace App\Repositories\Task;

use App\Models\Report;

interface TaskRepository
{
    public function create(array $data, ?Report $report): void;
}
