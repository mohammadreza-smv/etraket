<?php

function get_send_type_field($types){
    $array=array();
    $i=0;
    foreach ($types  as $type){
        $array[$i]=$type->type_key.'_send_time';
        $i++;
        $array[$i]=$type->type_key.'_send_price';
        $i++;
        $array[$i]=$type->type_key.'_min_order_price';
        $i++;
    }
    return $array;
}
