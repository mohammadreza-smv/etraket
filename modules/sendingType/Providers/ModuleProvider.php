<?php

namespace Modules\sendingType\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\sendingType\Repository\EloquentSendingTypeRepository;
use Modules\sendingType\Repository\SendingTypeRepositoryInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SendingTypeRepositoryInterface::class,EloquentSendingTypeRepository::class);
        $this->loadMigrationsFrom(base_path('modules/sendingType/database/migrations'));
        require_once base_path('modules/sendingType/helpers.php');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_panel_child_menu([
            'label'=>'هزینه ارسال سفارشات',
            'access'=>'setting',
            'parent_menu'=>'setting',
            'url'=>url('admin/setting/order/send-price')
        ]);

        add_panel_child_menu([
            'label'=>'شیوه های ارسال مرسوله',
            'access'=>'setting',
            'parent_menu'=>'setting',
            'url'=>url('admin/setting/sending_type')
        ]);
    }
}
