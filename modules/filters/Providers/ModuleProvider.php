<?php

namespace Modules\filters\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\filters\Repository\EloquentFilterRepository;
use Modules\filters\Repository\FilterRepositoryInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FilterRepositoryInterface::class,EloquentFilterRepository::class);
        $this->loadMigrationsFrom(base_path('modules/filters/database/migrations'));

        require_once base_path('modules/filters/helpers.php');
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
