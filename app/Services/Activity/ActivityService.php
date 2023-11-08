<?php

namespace App\Services\Activity;

use App\Exceptions\FailedCreateActivityException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use LaravelEasyRepository\BaseService;

interface ActivityService extends BaseService
{
    /**
     * @throws FailedCreateActivityException
     */
    public function createNewActivity(array $data);

    public function getAllActivity(bool $recent);

    public function storeImage(UploadedFile $file): bool|string;

    public function filterActivityByStatus(Collection $reports, string $status);
}
