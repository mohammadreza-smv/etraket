<?php

namespace Modules\affiliate\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use Modules\affiliate\Repository\AffiliateCommissionRepositoryInterface;
use Modules\affiliate\Repository\EloquentAffiliateCommissionRepository;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(base_path('modules/affiliate/database/migrations'));
        $this->app->bind(AffiliateCommissionRepositoryInterface::class,EloquentAffiliateCommissionRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_panel_menu([
            'label'=>'همکاری در فروش',
            'icon'=>'mdi-currency-usd',
            'access'=>'affiliate',
            'child'=>[
                ['url'=>url('admin/affiliate/commissions'),'label'=>'مدیریت کمیسون ها','access'=>'affiliate'],
            ]
        ],40);
    }
}
