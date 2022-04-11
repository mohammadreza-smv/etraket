<?php


namespace Modules\colors;

use App\BaseModule;
use Modules\colors\Repository\ColorRepositoryInterface;

class Module extends BaseModule
{
    protected $price_variation_field=false;

    protected $edit_color_id=0;

    protected $param_key;

    public function price_variation_item($data){
        return $data+[
            'Modules\colors\Module'=>'رنگ محصول'
        ];
    }

    public function before_show_view($args){
        $route=getRouteName();
        if($route==='price_variation_create' || $route==='price_variation_edit'){
            if(array_key_exists('variationItem',$args)){
                $i=0;
                foreach ($args['variationItem'] as $key=>$value){
                    if($value=='Modules\colors\Module'){
                        $this->param_key=$i;
                        $this->price_variation_field=true;
                        if($route==='price_variation_edit'){
                            $property='param'.str_replace('price_variation_item','',$key).'_id';
                            $this->edit_color_id=$args['price_variation']->$property;
                        }
                    }
                    $i++;
                }
            }
        }
        return $args;
    }

    public function price_variation_create_form(){
        return $this->price_variation_form();
    }

    public function price_variation_edit_form(){
        return $this->price_variation_form();
    }

    public function price_variation_index_table($data){
        $param1_type=$data[0]->param1_type;
        $param2_type=$data[0]->param2_type;
        $property=null;
        if($param1_type=='Modules\colors\Models\Color'){
            $property='param1';
        }
        elseif($param2_type=='Modules\colors\Models\Color'){
            $property='param2';
        }

        if($property){
            define('color_property',$property);
            return  [
                [
                    'label'=>'رنگ',
                    'attr'=>function($model){
                           $property=color_property;
                           if($model->$property){
                               $background=$model->$property->code;
                               $name=$model->$property->name;
                               $style=($name!='سفید') ? 'color:white' : '';
                               return '<span style="background:#'.$background.';padding:5px;border-radius:5px">
                                    <span  style="'.$style.'">'.Htmlspecialchars($name,ENT_QUOTES).'</span>
                                    </span>';
                           }
                           else{
                               return  'بدون رنگ';
                           }

                    },'html'=>true
                ]
            ];
        }
    }

    protected function price_variation_form(){
        if($this->price_variation_field){
            $repository=app(ColorRepositoryInterface::class);
            $items=$repository->selectList();
            return [
                'before_price1'=>[
                    'path'=>'colors::selectField',
                    'args'=>[
                        'colors'=>$items,
                        'color_id'=>$this->edit_color_id,
                    ],
                    'index'=>$this->param_key
                ]
            ];
        }
    }

    public function product_price_variation_saving($model){
        $repository=app(ColorRepositoryInterface::class);
        $repository->setProductColor($model);
    }

    public function addPriceVariation($data){
        $params=array_key_exists('params',$_POST) ? $_POST['params'] : [];
        $i=1;
        foreach ($params as $key=>$value)
        {
            $param_type=str_replace("'",'',$key);
            if($param_type=='Modules\colors\Models\Color'){

                $k1='param'.$i.'_id';
                $k2='param'.$i.'_type';
                $data=$data+[
                        $k1=>$value,
                        $k2=>$param_type
                    ];
            }
            $i++;
        }
        return $data;
    }

    public function set_cart_product_data($priceVariation){
        $value=null;
        if($priceVariation->param1_type=='Modules\colors\Models\Color'){
           $value=[
               'title'=>'رنگ',
               'value'=>$priceVariation->param1 ? $priceVariation->param1->name : '',
               'colorCode'=>$priceVariation->param1 ? $priceVariation->param1->code : '',
           ];
        }
        elseif($priceVariation->param2_type=='Modules\colors\Models\Color'){
            $value=[
                'title'=>'رنگ',
                'value'=>$priceVariation->param2 ? $priceVariation->param2->name : '',
                'colorCode'=>$priceVariation->param2 ? $priceVariation->param2->code : '',
            ];
        }
        if($value){
            if(is_array($priceVariation->price_params)){
                $array=$priceVariation->price_params;
                $array[]=$value;
                $priceVariation->price_params=$array;
            }
            else{
                $array[0]=$value;
                $priceVariation->price_params=$array;
            }
        }

        return $priceVariation;
    }

    public function set_user_access_list($access){
        $access['colors']=[
            'label'=>'رنگ ها',
            'access'=>[
                'color_edit'=>['label'=>'ثبت و ویرایش رنگ','routes'=>[
                    'colors.index','colors.create','colors.store','colors.edit','colors.update'
                ]],
                'remove_color'=>['label'=>'حذف رنگ','routes'=>['colors.index','colors.destroy']],
                'restore_color'=>['label'=>'بازیابی رنگ','routes'=>['colors.index','colors.restore']]
            ]
        ];

        return $access;
    }

    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName==='price_variation_create'
            || $routeName==='price_variation_edit'
            || config('view.search_components')==true
        ){
            return vue_component_detail('colors');
        }
    }

    public function begin_search_product_box()
    {
        if(view_type!='mobile'){
            return [
                [
                    'view'=>'colors::product.color_list',
                    'index'=>1,
                ]
            ];
        }
    }

    public function search_product_relation($relation)
    {
        $relation[]='productColor.getColor';
        return $relation;
    }
}
