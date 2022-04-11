<?php

namespace Modules\review\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\review\Repository\EloquentReViewRepository;
use Modules\review\Repository\ReViewRepositoryInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReViewRepositoryInterface::class,EloquentReViewRepository::class);
        $this->loadMigrationsFrom(base_path('modules/review/database/migrations'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
