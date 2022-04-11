<?php


namespace Modules\priceVariation\Models;


use App\CustomModel;

class PriceVariationItems extends CustomModel
{
    protected $table='price_variation_items';
    protected $guarded=[];
    public static function add_variation_items($cat_id,$data){
        $price_variation=$data['price_variation'];
        foreach ($price_variation as $key=>$value){
            if($value=='Modules\priceVariation\Module'){
                if(array_key_exists('price_variation_item',$data)){
                    $price_variation_item=$data['price_variation_item'][$key];
                    $position=0;
                    $price_variation_name=$data['price_variation_name'][$key];
                    foreach ($price_variation_item as $itemKey=>$itemValue) {
                        $position++;
                        if(!empty($itemValue['variation_value'])){
                            if ($itemValue['id'] === 0) {
                                self::insert([
                                    'variation_name' => $price_variation_name,
                                    'category_id' => $cat_id,
                                    'position' => $position,
                                    'variation_value'=>$itemValue['variation_value'],
                                    'variation_key'=>($key+1)
                                ]);
                            }
                            else{
                                self::where('id',$itemValue['id'])
                                    ->update([
                                        'variation_name' => $price_variation_name,
                                        'variation_value'=>$itemValue['variation_value'],
                                        'position'=>$position
                                    ]);
                            }
                        }
                    }
                }
            }
        }
    }
}
