<?php

namespace App\Repositories\Report;

use App\Models\Report;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ReportRepository
{
    public function getByDate(string $date, int $student_id): Report|Model|null;

    public function create(array $data): Report;

    public function all(bool $recent): Collection;
}
