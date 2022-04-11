<?php

namespace Modules\themes\Providers;

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
        require_once base_path('modules/themes/helpers.php');

        add_panel_menu([
            'label'=>'قالب ها',
            'icon'=>'mdi-pencil-ruler',
            'access'=>'themes',
            'name'=>'themes',
            'child'=>[
                ['url'=>url('admin/themes'),'label'=>'انتخاب قالب','access'=>'themes'],
                ['url'=>url('admin/themes/widgets'),'label'=>'ابزارک ها','access'=>'themes','target'=>'_blank']
            ]
        ],20);
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
