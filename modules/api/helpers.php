<?php

function getProductTozihat($html){
    $text=strip_tags($html);
    $text=str_replace("&shy;","",$text);
    $text=str_replace("&zwnj;"," ",$text);
    $text=str_replace("&zwnj;"," ",$text);
    $text=str_replace("&nbsp;"," ",$text);
    return $text;
}
function getBetweenTag($start,$end,$context){
    $result="";
    $text=explode($start,$context);
    if(isset($text[1])){
        $text=explode($end,$text[1]);
        $result=$text[0];
    }
    return $result;
}
