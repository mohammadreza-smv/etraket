<?php

namespace Modules\sadadpsp\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\setting\Repository\EloquentSettingRepository;
use Modules\setting\Repository\SettingRepositoryInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_panel_child_menu([
            'label'=>'درگاه سداد',
            'access'=>'setting',
            'parent_menu'=>'setting',
            'url'=>url('admin/setting/gateway/sadadpsp')
        ]);

    }
}
