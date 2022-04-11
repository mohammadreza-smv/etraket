<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use View;
class CMSProvider extends ServiceProvider
{
    protected $modules=[];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

       $path=base_path('modules');
       if(is_dir($path)){
           $directory=scandir($path);
           $directory=array_diff($directory,array(".",".."));
           foreach ($directory as $dir){
               if(is_dir($path.'/'.$dir)){
                  $this->modules[]=$dir;
                  $view_path=$path.'/'.$dir.'/resource/views';
                  View::addNameSpace($dir,$view_path);
               }
           }

           $this->addProvider();

           $this->addModuleMainClass();
           Config::set('app.modules',$this->modules);
       }

       $this->add_default_admin_menu();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $moduleMainClass=Config::get('app.modulesMainClass',[]);
        $front_theme=Config::get('cms.front-theme');
        if($front_theme){
            $file_path=base_path($front_theme.'/Module.php');
            $front_theme=str_replace("/","\\",$front_theme);
            $className="$front_theme\\Module";
            if(class_exists($className)){
                require_once ($file_path);
                $moduleMainClass['front_theme']=new $className;

                Config::set('app.modulesMainClass',$moduleMainClass);
            }

            $this->addThemeHelpers($front_theme);
        }
    }

    public function addProvider(){
        foreach ($this->modules as $module){
            $dir=base_path('modules/'.$module.'/Providers');
            if(is_dir($dir)){
                $files=scandir($dir);
                $files=array_diff($files,array(".",".."));
                foreach ($files as $file){
                    $class="\Modules\\".$module.'\\Providers\\'.str_replace('.php','',$file);
                    if(class_exists($class)){
                        $this->app->register($class);
                    }
                }
            }
        }
    }

    public function addModuleMainClass(){
        $moduleMainClass=[];
        foreach ($this->modules as $module){
            $file_path=base_path('modules/'.$module.'/Module.php');
            if(file_exists($file_path)){
                $className="Modules\\{$module}\\Module";
                if(class_exists($className)){
                    require_once ($file_path);
                    $moduleMainClass[$module]=new $className;
                }
            }
        }
        if(sizeof($moduleMainClass)>0){
            Config::set('app.modulesMainClass',$moduleMainClass);
        }
    }

    protected function  add_default_admin_menu(){
        add_panel_menu([
            'label'=>'مشاهده فروشگاه',
            'icon'=>'fa  fa-globe',
            'access'=>'files',
            'url'=>url('/')
        ],-1);
    }

    protected function addThemeHelpers($theme){
        $file_path=base_path($theme.'/helpers.php');
        $file_path=str_replace('\\','/',$file_path);
        if(file_exists($file_path)){
            require_once  $file_path;
        }
    }
}
