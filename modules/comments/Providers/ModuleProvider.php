<?php

namespace Modules\comments\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\comments\Repository\CommentRepositoryInterface;
use Modules\comments\Repository\EloquentCommentRepository;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CommentRepositoryInterface::class,EloquentCommentRepository::class);
        $this->loadMigrationsFrom(base_path('modules/comments/database/migrations'));
        add_panel_menu([
            'label'=>'نظرات کاربران',
            'icon'=>'mdi-comment-outline',
            'access'=>'comments',
            'url'=>url('admin/comments'),
            'count'=>":comment_count"
        ],10);
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
