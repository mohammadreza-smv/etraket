<?php

use \Modules\themes\Models\WidgetData;

function create_widgets_style($theme){

    $path=base_path('modules/themes/config');
    $files=scandir($path);
    $files=array_diff($files,array('.','..','.DS_Store'));

    $string='';
    foreach ($files as $file){
        $key=str_replace('.php','',$file);
        $key=str_replace($theme.'-','',$key);
        $design_config=get_design_config($theme,$key);
        $position=$key;
        if($design_config){
            $styles=array_key_exists('style',$design_config) ? $design_config['style'] : [];
            $responsive_style=array_key_exists('responsive_style',$design_config) ? $design_config['responsive_style'] : [];

            foreach ($styles as $id=>$style){
                $string.='#'.$position.' #'.$id.'{';
                if(is_array($style)){
                    foreach ($style as $key=>$value){
                        if(!empty($value)){
                            $styleName=getStyleName($key);
                            $string.=$styleName.':'.$value.';';
                        }
                    }
                }
                $string.='}';

            }

            foreach ($responsive_style as $k=>$array){
                $k=explode('_',$k);
                if(sizeof($k)>=3){
                    $type=$k[0];
                    $width=$k[(sizeof($k)-1)];
                    $id=get_responsive_el_id($k);
                    $string.='@media ('.$type.'-width:'.$width.'px){';

                    $string.='#'.$position.' #'.$id.'{';
                    foreach ($array as $styleKey=>$styleValue){
                        if(!empty($styleValue) && $styleKey!='type'){
                            $styleName=getStyleName($styleKey);
                            $string.=$styleName.':'.$styleValue.';';
                        }
                    }
                    $string.='} }';

                }
            }

        }
    }

    if($string!=''){
        $path=base_path('../public_html/css/widgets.css');
        file_put_contents($path,$string);

        $text=config('cms');
        $text['widgetId']=time();
        $text='<?php

return  '.var_export($text,true).';';

        file_put_contents(config_path('cms.php'),$text);
    }

}

function getStyleName($string){
    $styleName='';
    $array=preg_split('/(?=[A-Z])/',$string);
    $i=0;
    foreach ($array as $key=>$value){
        if(!empty($value)){
            $styleName.=strtolower($value);

            if($i<(sizeof($array)-1)){
                $styleName.='-';
                $i++;
            }
        }

    }

    return $styleName;
}

function get_widget_data($path,$vars){
    $widgetData=new WidgetData($path,$vars);
    return [
        'configs'=>$widgetData->getConfigs(),
        'args'=>$widgetData->getArgs()
    ];
}

function get_responsive_el_id($data){
    $id='';
    foreach ($data as $key=>$value)
    {
         if($key!=0 && $key!=((sizeof($data)-1))){
             $id.=$value;
             if($key!=((sizeof($data)-2))){
                 $id.='_';
             }
         }
    }
    return $id;
}

function get_design_config($themeName,$key){
    $file=base_path('modules/themes/config/'.$themeName.'-'.$key.'.php');
    if(file_exists($file)){
        require $file;
        return ${$key};
    }
    else{
        $file=base_path('modules/themes/config/'.$key.'.php');
        if(file_exists($file)){
            require $file;
            return ${$key};
        }
        return "null";
    }
}

function create_widgets_js($theme){
    $addList=['card','ul'];
    $removeKeyList=['title','content'];
    $path=base_path('modules/themes/config');
    $files=scandir($path);
    $files=array_diff($files,array('.','..','.DS_Store'));
    $dataArray=[];
    foreach ($files as $file){
        $key=str_replace('.php','',$file);
        $key=str_replace($theme.'-','',$key);
        $design_config=get_design_config($theme,$key);
        if($design_config && array_key_exists('tags',$design_config)){
            foreach ($design_config['tags'] as $tagId=>$tags){
                $check=array_search($tagId,$addList,true);
                if($check!==false){
                    if(sizeof($tags)>0){
                        foreach ($tags as $id=>$data){
                            foreach ($removeKeyList as $item){
                                if(array_key_exists($item,$data)){
                                    unset($data[$item]);
                                }
                            }
                            $dataArray[$id]=$data;
                        }
                    }
                }
            }
        }
    }

    $path=base_path('../public_html/js/widgets.js');
    $string='const widgetData='.json_encode($dataArray,true);
    file_put_contents($path,$string);

    $text=config('cms');
    $text['widgetId']=time();
    $text='<?php

return  '.var_export($text,true).';';

    file_put_contents(config_path('cms.php'),$text);
}
