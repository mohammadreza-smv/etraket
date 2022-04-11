<?php

namespace Modules\panelTheme\Providers;

use Illuminate\Support\ServiceProvider;
use themes\AdminPanel\Components\PanelBox;


class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewComponentsAs('',[
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

    }
}
