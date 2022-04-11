<?php

namespace Modules\sellers\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\sellers\components\PanelBox;
use Modules\sellers\Http\Middleware\CheckSellerAccount;
use Modules\sellers\Http\Middleware\RedirectIfAuthenticated;
use Modules\sellers\Http\Middleware\SellerAuth;
use Modules\sellers\Models\Seller;
use Modules\sellers\Repository\ApiRepositoryInterface;
use Modules\sellers\Repository\CommissionRepositoryInterface;
use Modules\sellers\Repository\EloquentApiRepository;
use Modules\sellers\Repository\EloquentCommissionRepository;
use Modules\sellers\Repository\EloquentSellerRepository;
use Modules\sellers\Repository\SellerRepositoryInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SellerRepositoryInterface::class,EloquentSellerRepository::class);
        $this->app->bind(ApiRepositoryInterface::class,EloquentApiRepository::class);
        $this->app->bind(CommissionRepositoryInterface::class,EloquentCommissionRepository::class);
        $this->loadMigrationsFrom(base_path('modules/sellers/database/migrations'));

        add_panel_menu([
            'name'=>'sellers',
            'label'=>'فروشندگان',
            'icon'=>'fa fa-shopping-basket',
            'access'=>'seller',
            'child'=>[
                ['url'=>url('admin/sellers/list'),'label'=>'مدیریت فروشندگان','access'=>'seller'],
                ['url'=>url('admin/sellers/commissions'),'label'=>'مدیریت کمیسیون ها','access'=>'seller','accessValue'=>'commission'],
                ['url'=>url('admin/sellers/payments'),'label'=>'پرداخت ها','access'=>'seller','accessValue'=>'payment'],
                ['url'=>url('admin/sellers/sms/channel'),'label'=>'تنظیمات ارسال پیامک','access'=>'seller'],
        ]
        ]);
        require_once base_path('modules/sellers/helpers.php');

        $guards=config('auth.guards');
        $guards['seller']=[
            'driver'=>'session',
            'provider'=>'seller_provider'
        ];
        config()->set('auth.guards',$guards);

        $providers=config('auth.providers');
        $providers['seller_provider']=[
            'driver'=>'eloquent',
            'model'=>Seller::class
        ];

        config()->set('auth.providers',$providers);

        $this->app['router']->aliasMiddleware('seller_guest', RedirectIfAuthenticated::class);
        $this->app['router']->aliasMiddleware('seller_auth', SellerAuth::class);
        $this->app['router']->aliasMiddleware('check_seller_account', CheckSellerAccount::class);
        $this->loadViewComponentsAs('seller',[
            PanelBox::class
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Database\Eloquent\Builder::macro('seller', function () {
            return $this->getModel()->belongsTo(Seller::class,'seller_id','id')
                ->withDefault(['id'=>0,'brand_name'=>config('shop-info.shop_name')]);
        });
    }
}
