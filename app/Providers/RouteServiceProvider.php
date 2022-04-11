<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Config;
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));

        Route::middleware('web')
            ->namespace($this->namespace.'\\Admin')
            ->group(base_path('routes/admin.php'));

        $modules=Config::get('app.modules');
        foreach ($modules as $module){
            $file=base_path('modules/'.$module.'/routes/web.php');
            if(file_exists($file)){
                $namespace="Modules\\".$module.'\Http\Controllers';
                Route::middleware('web')
                    ->namespace($namespace)
                    ->group($file);
            }
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware(['api','apiResponse'])
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));

        $modules=Config::get('app.modules');

        foreach ($modules as $module){
            $file=base_path('modules/'.$module.'/routes/api.php');
            if(file_exists($file)){
                $namespace="Modules\\".$module.'\Http\Controllers';

                Route::prefix('api')
                    ->middleware(['api','apiResponse'])
                    ->namespace($namespace)
                    ->group($file);
            }
        }
    }
}
