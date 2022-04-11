<?php

namespace Modules\productStatusNotification\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(base_path('modules/productStatusNotification/database/migrations'));
        require_once base_path('modules/productStatusNotification/helpers.php');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_panel_menu([
            'name'=>'status-notification',
            'label'=>'اطلاع رسانی موجود شدن محصولات',
            'icon'=>'mdi-bell-outline',
            'access'=>'status-notification',
            'child'=>[
                ['url'=>url('admin/notification/products'),'label'=>'محصولات در انتظار موجود شدن'],
                ['url'=>url('admin/notification/product/setting'),'label'=>'تنظیمات']
            ]
        ]);
    }
}
