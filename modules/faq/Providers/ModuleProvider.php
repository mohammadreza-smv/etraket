<?php

namespace Modules\faq\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\faq\Repository\CategoryRepositoryInterface;
use Modules\faq\Repository\EloquentCategoryRepository;
use Modules\faq\Repository\EloquentQuestionRepository;
use Modules\faq\Repository\QuestionRepositoryInterface;
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
        $this->app->bind(CategoryRepositoryInterface::class,EloquentCategoryRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class,EloquentQuestionRepository::class);
        $this->loadMigrationsFrom(base_path('modules/faq/database/migrations'));


        add_panel_menu([
            'label'=>'پرسش های متداول',
            'icon'=>'mdi-help',
            'access'=>'pages',
            'child'=>[
                ['url'=>url('admin/category-common-question'),'label'=>'مدیریت دسته ها','access'=>'pages'],
                ['url'=>url('admin/common-question'),'label'=>'مدیریت پرسش ها','access'=>'pages'],
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
