<?php

namespace Modules\productComparison\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\productComparison\Repository\EloquentProductComparisonRepository;
use Modules\productComparison\Repository\ProductComparisonRepositoryInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductComparisonRepositoryInterface::class,EloquentProductComparisonRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        require_once base_path('modules/productComparison/helpers.php');
    }
}
