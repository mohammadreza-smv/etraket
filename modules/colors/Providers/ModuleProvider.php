<?php

namespace Modules\colors\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use Modules\colors\Models\ProductColor;
use Modules\colors\Repository\ColorRepositoryInterface;
use Modules\colors\Repository\EloquentColorRepository;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ColorRepositoryInterface::class,EloquentColorRepository::class);
        $this->loadMigrationsFrom(base_path('modules/colors/database/migrations'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_panel_child_menu([
            'label'=>'مدیریت رنگ ها',
            'access'=>'colors',
            'url'=>url('admin/colors'),
            'parent_menu'=>'products'
        ]);

        \Illuminate\Database\Eloquent\Builder::macro('productColor', function () {
            return $this->getModel()->hasMany(ProductColor::class,'product_id','id');
        });
    }
}
