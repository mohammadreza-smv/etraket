<?php

namespace Modules\messages\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\messages\Repository\EloquentMessageRepository;
use Modules\messages\Repository\MessageRepositoryInterface;
use View;
use Auth;
class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MessageRepositoryInterface::class,EloquentMessageRepository::class);
        $this->loadMigrationsFrom(base_path('modules/messages/database/migrations'));


        add_panel_menu([
            'label'=>'پیام ها',
            'icon'=>'mdi-android-messages',
            'access'=>'messages',
            'url'=>url('admin/messages')
        ],20);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if(request()->is('admin/*') || request()->is('admin')){

        }

    }
}
