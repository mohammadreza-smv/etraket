<?php

namespace Modules\salesReport\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\pages\Repository\EloquentPageRepository;
use Modules\pages\Repository\PageRepositoryInterface;
use Modules\salesReport\Repository\EloquentSaleRepository;
use Modules\salesReport\Repository\SaleRepositoryInterface;
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
        $this->loadMigrationsFrom(base_path('modules/salesReport/database/migrations'));
        $this->app->bind(SaleRepositoryInterface::class,EloquentSaleRepository::class);
        add_panel_menu([
            'label'=>'گزارش فروش',
            'icon'=>'mdi-chart-bar',
            'access'=>'sales',
            'child'=>[
                ['url'=>url('admin/sales/province'),'label'=>'میزان سفارش هر استان','access'=>'sales'],
            ]
        ],15);
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
