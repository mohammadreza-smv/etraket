<?php

namespace Modules\shop;

use App\BaseModule;
use Modules\products\Models\Product;
use Modules\sellers\Models\Seller;
use Modules\sellers\Models\SellerProduct;

class Module extends BaseModule
{
    public function search_product_relation($data){
        $data[]='firstProductPrice';
        return $data;
    }

    public function product_list_query($query){

        $selected_cites=\Cookie::get('selected_shop_cites')!==null ? \Cookie::get('selected_shop_cites') : config()
            ->get('cms.selected_cites','');
        if($selected_cites && $selected_cites!=='all'){
            $e=explode('-',$selected_cites);
            $cities_id=[];
            foreach ($e as $id){
                if(!empty($id)){
                    $cities_id[$id]=$id;
                }
            }
            if(sizeof($cities_id)>0){
                $sellerProducts=Seller::whereIn('city_id',$cities_id)->pluck('id','id')->toArray();
                $products_id=SellerProduct::whereIn('seller_id',$sellerProducts)->pluck('product_id','product_id')->toArray();
                $query=$query->whereIn('id',$products_id);
            }
        }

        return $query;
    }

    public function search_product_query($query){
        $selected_cites=\Cookie::get('selected_shop_cites')!==null ? \Cookie::get('selected_shop_cites') : config()
            ->get('cms.selected_cites','');
        if($selected_cites && $selected_cites!=='all'){
            $e=explode('-',$selected_cites);
            $cities_id=[];
            foreach ($e as $id){
                if(!empty($id)){
                    $cities_id[$id]=$id;
                }
            }
            if(sizeof($cities_id)>0){
                $sellerProducts=Seller::whereIn('city_id',$cities_id)->pluck('id','id')->toArray();
                $products_id=SellerProduct::whereIn('seller_id',$sellerProducts)->pluck('product_id','product_id')->toArray();
                $query=$query->whereIn('id',$products_id);
            }
        }

        return $query;
    }

    public function city_citySellers_relation(){
        return function($self){
            return  $self->hasMany(Seller::class,'city_id','id')->where('account_status','active');
        };
    }
}
