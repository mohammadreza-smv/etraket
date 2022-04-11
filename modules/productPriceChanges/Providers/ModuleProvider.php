<?php

namespace Modules\productPriceChanges\Providers;

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
        $this->loadMigrationsFrom(base_path('modules/productPriceChanges/database/migrations'));
        require_once base_path('modules/productPriceChanges/helpers.php');
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
