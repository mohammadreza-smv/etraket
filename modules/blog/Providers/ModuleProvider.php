<?php

namespace Modules\blog\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\blog\Repository\BlogCategoryRepositoryInterface;
use Modules\blog\Repository\BlogPostRepositoryInterface;
use Modules\blog\Repository\EloquentBlogCategoryRepository;
use Modules\blog\Repository\EloquentBlogPostRepository;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BlogCategoryRepositoryInterface::class,EloquentBlogCategoryRepository::class);
        $this->app->bind(BlogPostRepositoryInterface::class,EloquentBlogPostRepository::class);

        $this->loadMigrationsFrom(base_path('modules/blog/database/migrations'));

        add_panel_menu([
            'name'=>'blog',
            'label'=>'وبلاگ',
            'icon'=>'mdi-post-outline',
            'access'=>'blog',
            'child'=>[
                ['url'=>url('admin/blog/posts'),'label'=>'پست ها','access'=>'blog'],
                ['url'=>url('admin/blog/categories'),'label'=>'دسته بندی ها','access'=>'blog'],
                ['url'=>url('admin/blog/comments'),'label'=>'نظرات','access'=>'blog'],
                ['url'=>url('admin/blog/domain'),'label'=>'تنظیمات دامنه','access'=>'blog']
            ]
        ],30);
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
