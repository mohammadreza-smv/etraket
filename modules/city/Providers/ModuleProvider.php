<?php

namespace Modules\city\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\city\Repository\CityRepositoryInterface;
use Modules\city\Repository\EloquentCityRepository;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CityRepositoryInterface::class,EloquentCityRepository::class);
        $this->loadMigrationsFrom(base_path('modules/city/database/migrations'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_panel_child_menu([
            'label'=>'مدیریت شهر ها',
            'access'=>'city',
            'url'=>url('admin/city'),
            'parent_menu'=>'area'
        ]);

    }
}
