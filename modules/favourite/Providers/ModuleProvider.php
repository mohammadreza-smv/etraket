<?php

namespace Modules\favourite\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\favourite\Repository\EloquentFavoriteRepository;
use Modules\favourite\Repository\FavoriteRepositoryInterface;


class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FavoriteRepositoryInterface::class,EloquentFavoriteRepository::class);
        $this->loadMigrationsFrom(base_path('modules/favourite/database/migrations'));
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
