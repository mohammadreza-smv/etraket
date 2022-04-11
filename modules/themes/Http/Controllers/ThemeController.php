<?php


namespace Modules\themes\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use Modules\themes\Jobs\WidgetJs;
use Modules\themes\Jobs\WidgetStyle;
use File;
class ThemeController extends Controller
{
    public function widgets(){
        return CView('themes::widgets');
    }

    public function widget_list(){

        $items=run_action('widgets',[],true);
        $widgets=[];
        foreach ($items as $item){
            if(is_array($item)){
                foreach ($item as $key=>$value){
                    $widgets[]=$value;
                }
            }
        }

        $areas=run_action('widget_location',[],true);
        $positions=[];
        foreach ($areas as $area){
            if(is_array($area)){
                foreach ($area as $key=>$value){
                    $positions[$key]=$value;
                }
            }
        }

        return [
            'widgets'=>$widgets,
            'positions'=>$positions
        ];
    }

    public function save_design_data(Request $request){

        $rows=$request->get('rows',[]);
        $style=$request->get('style',[]);
        $tagData=$request->get('tagData',[]);
        $position=$request->get('position');
        $responsive_style=$request->get('responsiveStyle');
        $use_template=$request->get('use_template','yes');
        $themeName=Config::get('cms.front-theme-name','');

        $path=base_path('modules/themes/config/'.$themeName.'-'.$position.'.php');
        if($use_template==='no'){
            $path=base_path('modules/themes/config/'.$position.'.php');
        }
        try{
            $rows=json_decode($rows);
            $style=json_decode($style);
            $tagData=json_decode($tagData);
            $responsive_style=json_decode($responsive_style);
            $data=[
                'rows'=>$rows,
                'style'=>$style,
                'tags'=>$tagData,
                'responsive_style'=>$responsive_style
            ];

            $data=var_export($data,true);
            $data=str_replace('(object)','',$data);

            $var=str_replace('-','_',$position);
            $rowsText='<?php $'.$var.'='.$data.'?>';

            File::put($path,$rowsText);

            WidgetStyle::dispatch($themeName);
            WidgetJs::dispatch($themeName);
            return 'ok';
        }
        catch (\Exception $e){
            return  'error';
        }
    }

    public function get_position_data($position){
        $themeName=Config::get('cms.front-theme-name','');
        return get_design_config($themeName,$position);
    }
}
