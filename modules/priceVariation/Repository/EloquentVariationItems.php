<?php


namespace Modules\priceVariation\Repository;


use Modules\categories\Models\Category;
use Modules\priceVariation\Models\PriceVariationItems;

class EloquentVariationItems implements VariationItemsInterface
{

    public function addItems($cat_id,$data)
    {
        $price_variation=$data['price_variation'];
        if(sizeof($price_variation)>0){

            $category=Category::where('id',$cat_id)->firstOrFail();
            if(array_key_exists(0,$price_variation)){
                $category->price_variation_item1=$price_variation[0];
            }
            if(array_key_exists(1,$price_variation)){
                $category->price_variation_item2=$price_variation[1];
            }
            $category->update();

            PriceVariationItems::add_variation_items($cat_id,$data);
        }
    }

    public function params($cat_id){
        $response=[];
        $items=PriceVariationItems::where('category_id',$cat_id)
            ->whereIn('variation_key',[1,2])->orderBy('position','ASC')->get();
        foreach ($items as $item){
            $size=array_key_exists(($item->variation_key-1),$response) ? sizeof($response[($item->variation_key-1)]) : 0;
            $response[($item->variation_key-1)][$size]=$item;
        }
        return $response;
    }

    public function find($id){
        return PriceVariationItems::find($id);
    }

    public function destroy($id){
        PriceVariationItems::where('id',$id)->delete();
    }

    public function getParam($key,$catId){
        return PriceVariationItems::where(['category_id'=>$catId,'variation_key'=>$key])
            ->orderBy('position','ASC')->get();
    }


}
