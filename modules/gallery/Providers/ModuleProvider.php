<?php

namespace Modules\gallery\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\gallery\Repository\EloquentGalleryRepository;
use Modules\gallery\Repository\GalleryRepositoryInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GalleryRepositoryInterface::class,EloquentGalleryRepository::class);
        $this->loadMigrationsFrom(base_path('modules/gallery/database/migrations'));
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
