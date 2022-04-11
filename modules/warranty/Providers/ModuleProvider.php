<?php

namespace Modules\warranty\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\warranty\Repository\EloquentWarrantyRepository;
use Modules\warranty\Repository\WarrantyRepositoryInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WarrantyRepositoryInterface::class,EloquentWarrantyRepository::class);
        $this->loadMigrationsFrom(base_path('modules/warranty/database/migrations'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_panel_child_menu([
            'label'=>'مدیریت گارانتی ها',
            'access'=>'warranties',
            'url'=>url('admin/warranties'),
            'parent_menu'=>'products'
        ]);
    }
}
