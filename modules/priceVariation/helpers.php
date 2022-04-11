<?php

function getVariationDetail($variation,$key){

    $param_key=$key.'_type';
    $result=false;

    if($variation){
        if($variation->$param_key=="Modules\priceVariation\Models\PriceVariationItems"){
            $result=[
                'label'=>$variation->$key->variation_name,
                'value'=>$variation->$key->variation_value
            ];
        }
        else{
            if(class_exists($variation->$param_key)){
                $result=[
                    'label'=>$variation->$param_key::$label,
                    'value'=>$variation->$key->name
                ];
            }
        }
    }

    return $result;

}

