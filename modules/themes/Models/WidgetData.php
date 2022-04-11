<?php

namespace Modules\themes\Models;

class WidgetData
{
    protected $path;

    protected $route_name;

    protected $themeName;

    protected $configs=[];

    protected $positions=[];

    protected $locationParam='';

    protected $factory;

    protected $args=[];

    public function __construct($path,$vars)
    {
        $this->factory = app(\Illuminate\View\Factory::class);

        $this->path=$path;
        $this->args=$vars;
        $this->route_name=getRouteName();
        $this->themeName=\Config::get('cms.front-theme-name','');
        $this->checkWidgetParam();
        $this->getContentFiles();
        $this->setConfigs();
    }

    protected function checkWidgetParam(){
        if(defined('widget_param')){
            $view_type='';
            if(defined('view_type')){
                $view_type=view_type=="" ? 'desktop' : view_type;
            }

            $file=$this->themeName.'-'.$view_type.'_'.$this->route_name.widget_param;
            if(file_exists(base_path('modules/themes/config/'.$file.'.php'))){
                $this->route_name=$this->route_name.widget_param;
                $this->locationParam=widget_param;
                define('locationParam',widget_param);
            }
        }
    }

    protected function getContentFiles(){
        $viewFile=$this->factory->getFinder()->find($this->path);
        if(file_exists($viewFile)){
            $viewFileContent=file_get_contents($viewFile);
            $this->addFileWidgetPositions($viewFileContent);
            $this->addLayoutPositions($viewFileContent);
            $this->includeFiles($viewFileContent);
        }
    }

    protected function addFileWidgetPositions($content){
        $n=explode("'location'=>'",$content);
        for($i=0;$i<sizeof($n);$i++){
            $result=getBetweenTag("'location'=>'","'",$content);
            $position=str_replace(':widgetParam',$this->locationParam,$result);
            if(trim($position)!=null && trim($position)){
                $this->positions[]=$position;
                $content=str_replace("'location'=>'".$result."'","",$content);
            }
        }
    }

    public function addLayoutPositions($content){
        $extends=getBetweenTag("@extends('","'",$content);
        if(trim($extends)!=null && trim($extends)!=''){
            $layout=$this->factory->getFinder()->find($extends);
            define('layout',$layout);
            if(file_exists($layout)){
                $layoutContent=file_get_contents($layout);
                $this->addFileWidgetPositions($layoutContent);
            }
        }
    }

    public function setConfigs(){
        $path=base_path('modules/themes/config');
        $files=scandir($path);
        $files=array_diff($files,array('.','..','.DS_Store'));
        foreach ($this->positions as $position){
            foreach ($files as $file) {
                if($this->themeName.'-'.$position.'.php'===$file || $position.'.php'===$file){
                    $config=get_design_config($this->themeName,$position);
                    $this->configs[$position]=$config;
                    if($config){
                        $this->addWidgetArgs($config);
                    }
                }
            }
        }
    }

    public function addWidgetArgs($config){

        $rows=array_key_exists('rows',$config) ? $config['rows'] : [];
        $tagData=array_key_exists('tags',$config) ? $config['tags'] : [];
        foreach ($rows as $row){

            if(array_key_exists('child',$row) && is_array($row['child'])){
                foreach ($row['child'] as $value1)
                {
                    if($value1['type']=='widget'){
                        $data=$tagData[$value1['tag']][$value1['id']];
                        $data['data_id']=$value1['id'];
                        $this->args=CompleteData($value1['tag'].'_widget',[$this->args,$data],true);
                    }
                    else if($value1['type']=='box'){

                        if(array_key_exists('child',$value1)){

                            foreach ($value1['child'] as $value2){
                                if($value2['type']=='widget'){
                                    $data=$tagData[$value2['tag']][$value2['id']];
                                    $data['data_id']=$value2['id'];
                                    $this->args=CompleteData($value2['tag'].'_widget',[$this->args,$data],true);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function getConfigs(){
        return $this->configs;
    }

    public function getArgs(){

        return $this->args;
    }

    protected function getBetweenTag($start,$end,$context){
        $result="";
        $text=explode($start,$context);
        if(isset($text[1])){
            $text=explode($end,$text[1]);
            $result=$text[0];
        }
        return $result;
    }

    public function includeFiles($content){
        $n=explode("'@include('",$content);
        for($i=0;$i<sizeof($n);$i++){
            $path=$this->getBetweenTag("@include('","'",$content);
            $content=str_replace("@include('".$path."'","",$content);
            if(!empty($path)){
                $viewFile=$this->factory->getFinder()->find($path);
                if(file_exists($viewFile)) {
                    $viewFileContent = file_get_contents($viewFile);
                    $this->addLayoutPositions($viewFileContent);
                }
            }
        }
    }
}
