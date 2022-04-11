<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Config;
use File;
class publishThemeAsset extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:publishAsset {--theme=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish asset themes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $option=$this->option('theme');
        $empty=true;
        $themes_path=base_path('themes');

        $themes=scandir($themes_path);

        $themes=array_diff($themes,array('.','..','.DS_Store'));
        foreach ($themes as $theme){
            if($option==$theme || $option==null){
                $asset_path=base_path('themes/'.$theme.'/assets');
                if(is_dir($asset_path)){
                    $files=scandir($asset_path);
                    $files=array_diff($files,array('.','..','.DS_Store'));

                    foreach ($files as $file){
                        $filePath=$asset_path.'/'.$file;

                        $new_path=public_path('themes/'.$theme).'/'.$file;

                        if(is_dir($filePath)){
                            File::copyDirectory($filePath,$new_path);
                            $empty=false;
                        }
                        else if(is_file($filePath)){
                            File::copy($filePath,$new_path);
                            $empty=false;
                        }

                    }
                }
            }
        }


        if(!$empty){
            $this->info('asset published');
        }
        else{
            $this->info('not found assets');
        }
    }
}
