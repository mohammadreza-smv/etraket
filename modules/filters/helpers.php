<?php

function is_selected_filter($list,$filter_id)
{
    $result=false;

    foreach ($list as $key=>$value)
    {
        if($value->filter_value==$filter_id)
        {
            $result=true;
        }
    }

    return $result;
}
function getFilterArray($list)
{
    $array=array();
    foreach ($list as $key=>$value)
    {
        $array[$value->item_id]=$key;
    }
    return $array;
}
function getFilterItemValue($filter_id,$product_filters)
{
    $string='';

    foreach ($product_filters as $key=>$value)
    {
        if($value==$filter_id)
        {
            $string.='@'.$key;
        }
    }

    return $string;
}
