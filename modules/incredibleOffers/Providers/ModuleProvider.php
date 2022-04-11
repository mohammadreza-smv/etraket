<?php

namespace Modules\incredibleOffers\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\incredibleOffers\Repository\EloquentIncredibleOffersRepository;
use Modules\incredibleOffers\Repository\IncredibleOffersRepositoryInterface;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IncredibleOffersRepositoryInterface::class,EloquentIncredibleOffersRepository::class);
        $this->loadMigrationsFrom(base_path('modules/incredibleOffers/database/migrations'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_panel_child_menu([
            'label'=>'پیشنهاد شگفت انگیز',
            'access'=>'incredible-offers',
            'url'=>url('admin/incredible-offers'),
            'parent_menu'=>'products'
        ]);

    }
}
