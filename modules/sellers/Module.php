<?php

namespace Modules\sellers;

use App\BaseModule;
use Modules\brands\Models\Brand;
use Modules\categories\Models\Category;
use Modules\city\Models\City;
use Modules\city\Repository\CityRepositoryInterface;
use Modules\province\Models\Province;
use Modules\province\Repository\ProvinceRepositoryInterface;
use Auth;
use Modules\sellers\Models\Seller;
use Modules\sellers\Models\SellerFollowers;
use Modules\sellers\Repository\SellerRepositoryInterface;

class Module extends BaseModule
{
    public function sellers_index_action(){

        return function ($model){
            $message_list_url=url('admin/sellers/'.$model->id.'/messages');

            $message_link='<a class="router-link" href="'.$message_list_url.'" style="color:black">
                       <v-icon>mdi-message-outline</v-icon>
                    </a> ';

            $products_list_url=url('admin/sellers/'.$model->id);

            $product_link='<a class="router-link" href="'.$products_list_url.'">
                       <v-icon>mdi-cart-outline</v-icon>
                    </a> ';
            return $message_link.' '.$product_link;
        };
    }

    public function add_message_type($types){
        $types['Modules\sellers\Models\Seller']=[
            'url_param'=>'sellers',
            'attr'=>'brand_name'
        ];
        return $types;
    }

    public function sellers_edit($data){

        if(interface_exists(ProvinceRepositoryInterface::class)){

            $provinceRepository=app(ProvinceRepositoryInterface::class);
            $province=$provinceRepository->arrayList();

            $cityRepository=app(CityRepositoryInterface::class);
            $city = $cityRepository->arrayList(['province_id'=>$data['seller']->province_id]);

            return [
                'province'=>$province,
                'city'=>$city
            ];
        }

    }

    public function sellers_edit_form(){
        return [
            'after_account_status'=>'sellers::location-field',
        ];
    }

    public function seller_global_data($relation){
        if(class_exists(Province::class)){
            $relation[]='province';
            $relation[]='city';
            return $relation;
        }
    }

    public function sellers_province_relation(){
        return function($self){
            return $self->belongsTo(Province::class,'province_id','id');
        };
    }

    public function sellers_city_relation(){
        return function($self){
            return $self->belongsTo(City::class,'city_id','id');
        };
    }

    public function product_list_relation($relations){
        $relations[]='seller';
        return $relations;
    }

    public function price_variation_list_relation($relations){
        if(Auth::check()){
            $relations[]='seller';
        }
        return $relations;
    }

    public function products_index_table($data){
        if(Auth::check() && (Auth::user()->role=='admin' || Auth::user()->role>0)){
            return [
                ['label'=>'فروشنده','attr'=>function($model){
                    if($model->seller){
                        return e($model->seller->brand_name);
                    }
                    else{
                        return  '';
                    }
                }]
            ];
        }
    }

    public function price_variation_index_table($data){
        if(Auth::check()){
            return [
                ['label'=>'فروشنده','attr'=>function($model){
                    if($model->seller){
                        return e($model->seller->brand_name);
                    }
                    else{
                        return  '';
                    }
                }]
            ];
        }
    }

    public function addPriceVariation($params){
        if(Auth::guard('seller')->check()){
            $seller_id=Auth::guard('seller')->user()->id;
            $params['seller_id']=$seller_id;
        }
        return $params;
    }

    public function registerComponent(){
        if(config('view.search_components')==true || config('seller_component')=='add'){
            return vue_component_detail('sellers');
        }
        else if( strstr(\URL::current(),'sellers')){
            return vue_component_detail('seller-panel','./modules/sellers/resource/js/panel.js');
        }
    }

    public function search_product_relation($data){
        $data[]='firstProductPrice.seller';
        return $data;
    }

    public function end_search_product_box()
    {
        if(getRouteName()!=='seller_page'){
            return [
                [
                    'view'=>'sellers::product.shop-detail',
                    'index'=>5,
                ]
            ];
        }
    }

    public function products_created($model){
        if(Auth::guard('seller')->check()){
            $id=Auth::guard('seller')->user()->id;
            $repository=app(SellerRepositoryInterface::class);
            $repository->addProduct($id,$model);
        }
    }

    public function product_price_variation_saving($model){
        if(Auth::guard('seller')->check() && empty($model->id)){
            $seller_id=Auth::guard('seller')->user()->id;
            $model->seller_id=$seller_id;
        }
    }

    public function price_variation_panel_list($model){
        if(Auth::guard('seller')->check()){
            $seller_id=get_seller_id();
            $model=$model->where('seller_id',$seller_id);
        }
        return $model;
    }

    public function products_index_form(){
        return [
            'after_status'=>'sellers::products_index'
        ];
    }

    public function before_show_view($args){
        if(getRouteName()==='products_index'){
            $catRepository=app(SellerRepositoryInterface::class);
            $sellers=$catRepository->sellers();
            unset($sellers['']);
            $sellers[0]=config('shop-info.shop_name');
            ksort($sellers);
            view()->share('sellers',$sellers);
        }
        return $args;
    }

    public function select_product_list($data){
        $products=$data[0];
        $string=$data[1];
        $request=request()->all();
        if(array_key_exists('seller_id',$request) && !empty($request['seller_id'])){
            $products=$products->where('seller_id',$request['seller_id']);
            $string=create_paginate_url($string,'seller_id='.$request['seller_id']);
        }
        return [$products,$string];
    }

    public function commissions_category_relation(){
        return function($self){
            return $self->hasone(Category::class,'id','cat_id');
        };
    }

    public function commissions_brand_relation(): \Closure
    {
        return function($self){
            return $self->hasone(Brand::class,'id','brand_id');
        };
    }

    public function add_product_sale($data){
        $repository=app(SellerRepositoryInterface::class);
        $repository->add_seller_sale($data);
    }

    public function list_index_right_click(){
        return [
            'statistics'=>[
                'label'=>'آمار فروش',
                'url'=>'sellers/:id/statistics',
                'icon'=>'mdi-chart-line'
            ]
        ];
    }

    public function search_product_query($query){
        $request=request();
        if($request->route()->parameter('id')){
            $seller_id=$request->route()->parameter('id');
            $repository=app(SellerRepositoryInterface::class);
            $productsId=$repository->getProductsId($seller_id);
            $query=$query->whereIn('id',$productsId);
            $brands=$request->get('brand');
            $categories=$request->get('category');
            if($request->has('brand')){
                $query=$query->whereIn('brand_id',$brands);
            }
            if($request->has('category')){
                $query=$query->whereIn('cat_id',$categories);
            }
        }
        else if($request->route()->uri==='seller/followed/products' || $request->route()->uri='getProduct/seller/followed/products'){
            $query=get_search_followed_products_query($query);
        }
        return $query;
    }

    public function search_filters($args){
        $previous_url=url()->previous();
        if(str_contains($previous_url,'seller')){

            $seller_id=str_replace(url('seller/'),'',$previous_url);
            $seller_id=str_replace('/','',$seller_id);

            $repository=app(SellerRepositoryInterface::class);
            $brands=$repository->brandsUsed($seller_id);
            $args['brands']=$brands;

            $categories=[];
            $result=$repository->categoriesUsed($seller_id);
            foreach ($result as $value){
                if($value->category){
                    $categories[]=['id'=>$value->cat_id,'title'=>$value->category->name];
                }
            }
            $args['customItems'][]=['items'=>$categories,'title'=>'دسته بندی ها','param'=>'category'];
        }
        return $args;
    }

    public function before_variation_detail(){
        return [
            [
                'index'=>0,
                'view'=>'sellers::product.variation-item'
            ]
        ];
    }

    public function show_product_relation($data){
        $data[]='PriceVariation.seller';
        return $data;
    }

    public function product_page_variation_query($query){
        $query=$query->with('seller');
        return $query;
    }

    public function widgets(): array
    {
        return [
            [
                'name'=>'products_sellers_followed',
                'title'=>'لیست محصولات دنبال شده',
                'view'=>'sellers::products_sellers_followed'
            ]
        ];
    }

    public function products_sellers_followed_widget($args,$data){
        if(\Auth::check()){
            $user=\Auth::user();
            $repository=app(SellerRepositoryInterface::class);
            $args['followed_product']=$repository->getLastFollowedProduct($user->id);
        }
        return $args;
    }

    public function get_product_variations($query){
        return $query->with('seller');
    }

    public function product_variation_list_params(): array
    {
        return [
            [
                'view'=>'sellers::product.variation_list_param',
                'index'=>0,
            ]
        ];
    }
}


