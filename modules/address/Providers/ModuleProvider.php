<?php

namespace Modules\address\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\address\Repository\AddressRepositoryInterface;
use Modules\address\Repository\EloquentAddressRepository;


class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AddressRepositoryInterface::class,EloquentAddressRepository::class);
        $this->loadMigrationsFrom(base_path('modules/address/database/migrations'));
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
