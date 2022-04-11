<?php

namespace Modules\themes\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
class WidgetStyle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $theme;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($theme)
    {
        $this->theme=$theme;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        create_widgets_style($this->theme);
    }
}
