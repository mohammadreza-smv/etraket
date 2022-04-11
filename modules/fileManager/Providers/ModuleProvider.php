<?php

namespace Modules\fileManager\Providers;

use Illuminate\Support\ServiceProvider;
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
        add_panel_menu([
            'label'=>'مدیریت فایل ها',
            'icon'=>'mdi-file-multiple',
            'access'=>'files',
            'url'=>url('admin/filemanager')
        ],3);
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
