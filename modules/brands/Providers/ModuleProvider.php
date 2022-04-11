<?php

namespace Modules\brands\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use Modules\brands\Models\Brand;
use Modules\brands\Repository\BrandRepositoryInterface;
use Modules\brands\Repository\EloquentBrandRepository;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BrandRepositoryInterface::class,EloquentBrandRepository::class);
        $this->loadMigrationsFrom(base_path('modules/brands/database/migrations'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_panel_child_menu([
            'label'=>'مدیریت برند ها',
            'access'=>'brands',
            'url'=>url('admin/brands'),
            'parent_menu'=>'products'
        ]);

        \Illuminate\Database\Eloquent\Builder::macro('getBrand', function () {
            return $this->getModel()->hasOne(Brand::class,'id','brand_id')
                ->withDefault(['brand_name'=>'','brand_ename'=>''])
                ->select(['brand_name','brand_ename','brand_icon','id']);
        });
    }
}
