<?php

namespace Modules\priceVariation\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\priceVariation\Repository\EloquentPriceVariationRepository;
use Modules\priceVariation\Repository\EloquentVariationItems;
use Modules\priceVariation\Repository\PriceVariationRepositoryInterface;
use Modules\priceVariation\Repository\VariationItemsInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VariationItemsInterface::class,EloquentVariationItems::class);
        $this->app->bind(PriceVariationRepositoryInterface::class,EloquentPriceVariationRepository::class);
        $this->loadMigrationsFrom(base_path('modules/priceVariation/database/migrations'));
        require_once base_path('modules/priceVariation/helpers.php');
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
