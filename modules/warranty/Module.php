<?php
namespace Modules\warranty;

use App\BaseModule;
use Modules\warranty\Repository\WarrantyRepositoryInterface;

class Module extends BaseModule
{
    protected $price_variation_field=false;

    protected $edit_warranty_id=null;

    protected $param_key;

    public function price_variation_item($data){
        return $data+[
             'Modules\warranty\Module'=>'گارانتی محصول'
        ];
    }

    public function before_show_view($args){
        $route=getRouteName();
        if($route==='price_variation_create' || $route==='price_variation_edit'){
            if(array_key_exists('variationItem',$args)){
                $i=0;
                foreach ($args['variationItem'] as $key=>$value){
                    if($value=='Modules\warranty\Module'){
                        $this->price_variation_field=true;
                        $this->param_key=$i;
                        if($route==='price_variation_edit'){
                            $property='param'.str_replace('price_variation_item','',$key).'_id';
                            $this->edit_warranty_id=$args['price_variation']->$property;
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

    public function price_variation_index_table($data){
        $param1_type=$data[0]->param1_type;
        $param2_type=$data[0]->param2_type;
        $property=null;
        if($param1_type=='Modules\warranty\Models\Warranty'){
            $property='param1';
        }
        elseif($param2_type=='Modules\warranty\Models\Warranty'){
            $property='param2';
        }


        if($property){
            define('warranty_property',$property);
            return  [
                [
                    'label'=>'گارانتی',
                    'attr'=>function($model){
                        $property=warranty_property;
                        if($model->$property){
                            return $model->$property->name;
                        }
                        else{
                            return  '';
                        }
                    }
                ]
            ];
        }
    }

    public function price_variation_edit_form(){
        return $this->price_variation_form();
    }

    protected function price_variation_form(){
        if($this->price_variation_field){
            $repository=app(WarrantyRepositoryInterface::class);
            $items=$repository->selectList();
            return [
                'before_price1'=>[
                    'path'=>'warranty::selectField',
                    'args'=>[
                        'warranties'=>$items,
                        'edit_warranty_id'=>$this->edit_warranty_id
                    ],
                    'index'=>$this->param_key
                ]
            ];
        }
    }

    public function addPriceVariation($data){
        $params=array_key_exists('params',$_POST) ? $_POST['params'] : [];
        $i=1;
        foreach ($params as $key=>$value)
        {
            $param_type=str_replace("'",'',$key);
            if($param_type=='Modules\warranty\Models\Warranty'){

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
        if($priceVariation->param1_type=='Modules\warranty\Models\Warranty'){
            $value=[
                'title'=>'گارانتی',
                'value'=>$priceVariation->param1->name,
            ];
        }
        elseif($priceVariation->param2_type=='Modules\warranty\Models\Warranty'){
            $value=[
                'value'=>$priceVariation->param2->name,
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

    public function product_variation_list_params(): array
    {
        return [
            [
                'view'=>'warranty::variation_list_param',
                'index'=>0,
            ]
        ];
    }

    public function registerComponent(){
        if(!request()->has('request-type')){
            return vue_component_detail('warranty');
        }
    }
}
