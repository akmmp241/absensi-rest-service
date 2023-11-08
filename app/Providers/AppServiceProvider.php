<?php

namespace App\Providers;

use App\Repositories\Report\ReportRepository;
use App\Repositories\Report\ReportRepositoryImplement;
use App\Repositories\Task\TaskRepository;
use App\Repositories\Task\TaskRepositoryImplement;
use App\Services\Activity\ActivityService;
use App\Services\Activity\ActivityServiceImplement;
use App\Services\Response\ResponseService;
use App\Services\Response\ResponseServiceImplement;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ReportRepository::class,ReportRepositoryImplement::class);
        $this->app->bind(TaskRepository::class,TaskRepositoryImplement::class);
        $this->app->bind(ActivityService::class,ActivityServiceImplement::class);
        $this->app->bind(ResponseService::class, ResponseServiceImplement::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
