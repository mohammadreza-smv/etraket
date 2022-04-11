<?php

namespace Modules\priceVariation;

use App\BaseModule;
use Modules\priceVariation\Models\PriceVariation;
use Modules\priceVariation\Repository\PriceVariationRepositoryInterface;
use Modules\priceVariation\Repository\VariationItemsInterface;
use Auth;
class Module extends BaseModule
{
    protected $price_variation_item1=null;

    protected $price_variation_item2=null;

    protected $param1_id=0;

    protected $param2_id=0;

    protected $catId=0;

    protected $param_key='';

    public function category_index_right_click(){
        return [
            'price_variation'=>[
                'label'=>'ثبت تنوع قیمت محصولات',
                'url'=>'category/:id/price_variation',
                'icon'=>'mdi-cash-100'
            ]
        ];
    }

    public function products_index_right_click(){
        return [
            'price_variation'=>[
                'label'=>'ثبت تنوع قیمت',
                'url'=>'product/price_variation?product_id=:id',
                'icon'=>'mdi-cash-100'
            ]
        ];
    }

    public function before_show_view($data){
        $routeName=getRouteName();
        if($routeName==='price_variation_create' || $routeName==='price_variation_edit'){
            if(array_key_exists('variationItem',$data)){
                $i=0;
                foreach ($data['variationItem'] as $key=>$value){
                    if($value=='Modules\priceVariation\Module'){
                        $this->$key=true;
                        $this->param_key=$i;
                        if($routeName==='price_variation_edit'){
                            $property='param'.str_replace('price_variation_item','',$key).'_id';
                            $this->$property=$data['price_variation']->$property;
                        }
                    }
                    elseif($key=="cat_id"){
                        $this->catId=$value;
                    }
                    $i++;
                }
            }
        }
        return $data;
    }


    public function price_variation_create_form(){
        return $this->price_variation_form();
    }

    public function price_variation_edit_form(){
        return $this->price_variation_form();
    }

    public function price_variation_form(){
        $params1=null;
        $params2=null;
        $repository=app(VariationItemsInterface::class);
        if($this->price_variation_item1){
            $params1=$repository->getParam(1,$this->catId);
        }
        if($this->price_variation_item2){
            $params2=$repository->getParam(2,$this->catId);

        }
        return [
            'before_price1'=>[
                'path'=>'priceVariation::panel.selectField',
                'args'=>[
                    'variation_param1'=>$params1,
                    'variation_param2'=>$params2,
                    'param1_id'=>$this->param1_id,
                    'param2_id'=>$this->param2_id
                ],
                'index'=>$this->param_key
            ]
        ];
    }

    public function price_variation_index_table($data){
        $param1_type=$data[0]->param1_type;
        $param2_type=$data[0]->param2_type;
        $result=[];
        if($param1_type=='Modules\priceVariation\Models\PriceVariationItems'){
            if($data[0]->param1){
                $label=$data[0]->param1->variation_name;
                $result=[
                    ['label'=>$label,'attr'=>function($model){
                        return $model->param1->variation_value;
                    }]
                ];
            }

        }
        if($param2_type=='Modules\priceVariation\Models\PriceVariationItems'){
            if($data[0]->param2){
                $label=$data[0]->param2->variation_name;
                $result[]=['label'=>$label,'attr'=>function($model){
                    return $model->param2->variation_value;
                }];
            }

        }
        return $result;
    }

    public function product_price_variation_updated($model){
        $this->set_min_product_price($model);
    }

    public function product_price_variation_created($model){
        $this->set_min_product_price($model);
    }

    public function product_price_variation_restored($model){
        $this->set_min_product_price($model);
    }

    public function product_price_variation_deleted($model){

        $this->set_min_product_price($model);
    }

    protected function set_min_product_price($model){
        $repository=app(PriceVariationRepositoryInterface::class);
        $repository->setProductMainPrice($model);

        if($model){

            $sum=PriceVariation::where('product_id',$model->product_id)
                ->sum('product_number');
            \DB::table('products')->where('id',$model->product_id)
                ->update([
                    'product_count'=>$sum
                ]);
        }

    }

    public function addPriceVariation($data){
        $params=array_key_exists('params',$_POST) ? $_POST['params'] : [];
        $i=1;
        foreach ($params as $key=>$value)
        {
            $param_type=str_replace("'",'',$key);
            $param_type=str_replace("\param1",'',$param_type);
            $param_type=str_replace("\param2",'',$param_type);
            if($param_type=='Modules\priceVariation\Models\PriceVariationItems'){

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

    public function show_product_relation($data){
        $data[]='PriceVariation';
        return $data;
    }

    public function products_PriceVariation_relation(){
        return function($self){
            return $self->hasMany(PriceVariation::class,'product_id','id')
                ->where('product_number','>',0)
                ->orderBy('price2','ASC')->with(['param1','param2']);
        };
    }

    public function products_FirstPriceVariation_relation(){
        return function($self){
            return $self->hasOne(PriceVariation::class,'product_id','id')
                ->where('product_number','>',0)
                ->orderBy('price2','ASC')
                ->with(['param1','param2']);
        };
    }

    public function set_cart_product_data($priceVariation){
        $value=null;
        if($priceVariation->param1_type=='Modules\priceVariation\Models\PriceVariationItems'){
            $value=[
                'title'=>$priceVariation->param1 ? $priceVariation->param1->variation_name : '',
                'value'=>$priceVariation->param1 ? $priceVariation->param1->variation_value : '',
            ];
        }
        elseif($priceVariation->param2_type=='Modules\priceVariation\Models\PriceVariationItems'){
            $value=[
                'title'=>$priceVariation->param2 ? $priceVariation->param2->variation_name : '',
                'value'=>$priceVariation->param2 ? $priceVariation->param2->variation_value : '',
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

    public function products_firstProductPrice_relation(){
        return function ($self){
          return $self->hasOne(PriceVariation::class,'product_id','id')
              ->orderBy('price2','ASC');
        };
    }


    public function set_user_child_access($access){
        if(array_key_exists('category',$access)){
            $access['category']['access']['price_variation']=['label'=>'مدیریت تنوع قیمت','routes'=>[
                'priceVariationItems','add_price_variation','price_variation.destroy'
            ]];
        }

        if(array_key_exists('products',$access)){
            $access['products']['access']['price_variation']=['label'=>'ثبت تنوع قیمت','routes'=>[
                'price_variation.index','price_variation.create','price_variation.store','price_variation.edit','price_variation.update',
                'price_variation.destroy','product/price_variation.restore'
            ]];
        }
        return $access;
    }

    public function orders_show_table($data){

        return  [
            [
                'label'=>'تنوع اول محصول',
                'attr'=>function($model){
                     if($model->param1){
                         if($model->param1_type=='Modules\colors\Models\Color'){
                             return  'رنگ :'.$model->param1->name;
                         }
                         elseif ($model->param1_type=='Modules\warranty\Models\Warranty'){
                             return  $model->param1->name;
                         }
                         else{
                             return  $model->param1->variation_name.':'.$model->param1->variation_value;
                         }
                     }
                     else{
                         return  '';
                     }

                },
                'style'=>'min-width:150px'
            ],
            [
                'label'=>'تنوع دوم محصول',
                'attr'=>function($model){
                    if($model->param2){
                        if($model->param2_type=='Modules\colors\Models\Color'){
                            return  'رنگ :'.$model->param2->name;
                        }
                        elseif ($model->param2_type=='Modules\warranty\Models\Warranty'){
                            return  $model->param2->name;
                        }
                        else{
                            return  $model->param2->variation_name.':'.$model->param2->variation_value;
                        }
                    }
                    else{
                        return  '';
                    }
                },
                'style'=>'min-width:150px'
            ]
        ];
    }

    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName=='show_product' || $routeName=='priceVariationItems'){
            return vue_component_detail('priceVariation');
        }
    }

    public function select_product_list($data){
        $products=$data[0];
        $string=$data[1];
        $request=request()->all();
        if(array_key_exists('order_by',$request)){
            if($request['order_by']=='desc-sum'){
                $products=$products->orderBy('product_count','DESC');
            }
            else if($request['order_by']=='asc-sum'){
                $products=$products->orderBy('product_count','ASC');
            }
            $string=create_paginate_url($string,'order_by='.$request['order_by']);
        }
        return [$products,$string];
    }

    public function products_index_table($data){
        if(Auth::check() && (Auth::user()->role=='admin' || Auth::user()->role>0)){
            return [
                ['label'=>'تعداد قابل فروش','attr'=>function($model){
                    if($model->product_count>0){
                        return e(replace_number($model->product_count));
                    }
                    else{
                        return "۰";
                    }
                }]
            ];
        }
    }

    public function product_list_ordering($list){
        $list['desc-sum']='بیش ترین موجودی محصول';
        $list['asc-sum']='کمترین موجودی محصول';
        return $list;
    }
}
