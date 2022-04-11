<?php

namespace Modules\pages\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\pages\Repository\EloquentPageRepository;
use Modules\pages\Repository\PageRepositoryInterface;
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
        $this->app->bind(PageRepositoryInterface::class,EloquentPageRepository::class);
        $this->loadMigrationsFrom(base_path('modules/pages/database/migrations'));

        add_panel_menu([
            'label'=>'صفحات اضافی',
            'icon'=>'mdi-file-document-outline',
            'access'=>'pages',
            'child'=>[
                ['url'=>url('admin/pages'),'label'=>'مدیریت صفحات','access'=>'pages'],
                ['url'=>url('admin/pages/create'),'label'=>'افزودن صفحه جدید','access'=>'pages'],
            ]
        ]);
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
