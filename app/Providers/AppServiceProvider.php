<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Request;
use Config;
use View;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::addNameSpace('backend-theme',base_path('themes/AdminPanel'));
        View::addNameSpace('front-theme',base_path('themes/theme1'));
        Config::set('cms.front-theme','themes/theme1');
        Config::set('cms.backend-theme','themes/theme1');

        Config::set('cms.front-theme-name','theme1');

        Paginator::useBootstrap();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
