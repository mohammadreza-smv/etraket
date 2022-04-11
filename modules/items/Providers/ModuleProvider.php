<?php

namespace Modules\items\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\categories\Repository\CategoryRepositoryInterface;
use Modules\categories\Repository\EloquentCategoryRepository;
use Modules\items\Models\ItemValue;
use Modules\items\Repository\EloquentItemRepository;
use Modules\items\Repository\ItemRepositoryInterface;
use Request;
use Config;
class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ItemRepositoryInterface::class,EloquentItemRepository::class);
        $this->loadMigrationsFrom(base_path('modules/items/database/migrations'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Database\Eloquent\Builder::macro('itemValue', function () {
            return $this->getModel()->hasMany(ItemValue::class,'product_id','id');
        });
    }
}
