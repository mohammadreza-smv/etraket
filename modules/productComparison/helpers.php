<?php

function get_compare_product_id($data)
{
    $array=array();
    $i=0;
    if(is_array($data))
    {
        foreach ($data as $key=>$value)
        {
            if(!empty($value))
            {
                $array[$i]=str_replace('dkp-','',$value);
                $i++;
            }
        }
    }
    return $array;
}

function get_item_value($key,$products,$item_id){
    $string='';
    if(sizeof($products)>$key)
    {
        foreach ($products[$key]->itemValue as $item)
        {
            if($item_id==$item->item_id)
            {
                $string.=$item->item_value.'<br>';
            }
        }
    }
    return $string;
}
