<?php

namespace Modules\orders\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\orders\Models\Orders;
use Modules\orders\Repository\EloquentOrdersRepository;
use Modules\orders\Repository\EloquentSubmissionRepository;
use Modules\orders\Repository\OrdersRepositoryInterface;
use Modules\orders\Repository\SubmissionRepositoryInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OrdersRepositoryInterface::class,EloquentOrdersRepository::class);
        $this->app->bind(SubmissionRepositoryInterface::class,EloquentSubmissionRepository::class);
        $this->loadMigrationsFrom(base_path('modules/orders/database/migrations'));
        require_once base_path('modules/orders/helpers.php');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $child=[
            ['url'=>url('admin/orders'),'label'=>'مدیریت سفارشات','access'=>'orders'],
            ['url'=>url('admin/orders/submissions'),'label'=>'مدیریت مرسوله ها','access'=>'orders']
        ];

        $submissionsTitle=submissionsTitle();

        foreach ($submissionsTitle as $key=>$value){
            if($key>0){
                $child[]=[
                    'url'=>url('admin/orders/submissions/send_type/'.$key),
                    'label'=>$value,
                    'access'=>'orders',
                    'accessValue'=>'submission_'.$key.'_send_type'
                ];
            }
        }

        add_panel_menu([
            'name'=>'orders',
            'label'=>'سفارشات',
            'icon'=>'mdi-cart',
            'access'=>'orders',
            'child'=>$child
        ],5);

    }
}
