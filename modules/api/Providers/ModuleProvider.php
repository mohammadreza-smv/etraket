<?php

namespace Modules\api\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\api\Repository\ApiRepositoryInterface;
use Modules\api\Repository\EloquentApiRepository;
use Modules\cart\Repository\CartRepositoryInterface;
use Modules\cart\Repository\EloquentCartRepository;


class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApiRepositoryInterface::class,EloquentApiRepository::class);

        require_once base_path('modules/api/helpers.php');
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
