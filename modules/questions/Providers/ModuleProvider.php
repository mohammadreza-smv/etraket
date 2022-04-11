<?php

namespace Modules\questions\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\questions\Repository\EloquentQuestionRepository;
use Modules\questions\Repository\QuestionRepositoryInterface;


class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QuestionRepositoryInterface::class,EloquentQuestionRepository::class);
        $this->loadMigrationsFrom(base_path('modules/questions/database/migrations'));

        add_panel_menu([
            'label'=>'پرسش های کاربران',
            'icon'=>'mdi-help-circle-outline',
            'access'=>'questions',
            'url'=>url('admin/questions'),
            'count'=>":question_count"
        ],12);
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
