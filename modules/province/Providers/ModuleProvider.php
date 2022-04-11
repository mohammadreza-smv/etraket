<?php

namespace Modules\province\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\province\Repository\EloquentProvinceRepository;
use Modules\province\Repository\ProvinceRepositoryInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProvinceRepositoryInterface::class,EloquentProvinceRepository::class);
        $this->loadMigrationsFrom(base_path('modules/province/database/migrations'));

        add_panel_menu([
            'label'=>'مناطق',
            'icon'=>'mdi-map-marker',
            'access'=>'location',
            'name'=>'area',
            'child'=>[
                ['url'=>url('admin/province'),'label'=>'مدیریت استان ها','access'=>'location']
            ]
        ],5);
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
