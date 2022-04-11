<?php

namespace Modules\catBrands\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\catBrands\Repository\CatBrandRepositoryInterface;
use Modules\catBrands\Repository\EloquentCatBrandRepository;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CatBrandRepositoryInterface::class,EloquentCatBrandRepository::class);
        $this->loadMigrationsFrom(base_path('modules/catBrands/database/migrations'));
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
