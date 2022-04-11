<?php

namespace Modules\visitStatistics\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    public function register(){
        $this->loadMigrationsFrom(base_path('modules/visitStatistics/database/migrations'));
    }
}
