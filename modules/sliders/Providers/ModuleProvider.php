<?php

namespace Modules\sliders\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\sliders\Repository\EloquentSliderRepository;
use Modules\sliders\Repository\SliderRepositoryInterface;
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
        $this->app->bind(SliderRepositoryInterface::class,EloquentSliderRepository::class);
        $this->loadMigrationsFrom(base_path('modules/sliders/database/migrations'));

        add_panel_menu([
            'label'=>'اسلایدر ها',
            'icon'=>'mdi-play-box-outline',
            'access'=>'sliders',
            'child'=>[
                ['url'=>url('admin/sliders'),'label'=>'مدیریت اسلایدر ها','access'=>'sliders'],
                ['url'=>url('admin/sliders/create'),'label'=>'افزودن اسلایدر','access'=>'sliders'],
            ]
        ],2);
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
