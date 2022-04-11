<?php

function getVariationParamData($variation){

    $result=[];

    if($variation->param1_type=="Modules\\priceVariation\\Models\\PriceVariationItems"){
        $result['name']=$variation->param1->variation_value;
        $result['id']=$variation->param1->id;
    }
    else if($variation->param1_type=="Modules\\colors\\Models\\Color"){
        $result['name']=$variation->param1->name;
        $result['id']=$variation->param1->id;
        $result['code']=$variation->param1->code;
    }
    else if($variation->param1_type=="Modules\\warranty\\Models\\Warranty"){
        $result['name']=$variation->param1->name;
        $result['id']=$variation->param1->id;
    }

    return $result;
}

function get_product_price_changed($product_id)
{
    $array=array();
    $jdf=new \App\Lib\Jdf();
    $points=[];
    $paramName='رنگ';
    $timeStamp=strtotime('-30 day');

    $variationParams=\Modules\priceVariation\Models\PriceVariation::where('product_id',$product_id)
        ->with('param1')->get()->unique('param1_id');


    $product_price=\Modules\productPriceChanges\Models\PriceChanges::with([
        'priceVariation'=>function($query){
            $query->withTrashed();
        }
    ])->where('product_id',$product_id)
      ->where('time','>=',$timeStamp)->get();

    if(sizeof($variationParams)>0){
        if($variationParams[0]->param1_type=="Modules\\priceVariation\\Models\\PriceVariationItems"){
            $paramName=$variationParams[0]->param1->variation_name;
        }
        else if($variationParams[0]->param1_type=="Modules\\warranty\\Models\\Warranty"){
            $paramName="گارانتی";
        }
    }

    $changes=[];
    $price=[];
    $seller=[];
    $param1=[];
    $zone=[];

    foreach($product_price as $key=>$value)
    {
        $date=$jdf->tr_num($jdf->jdate('Y-n-j',$value->time));
        $changes[$date][$value->param1_id]=intval($value->price);
        $seller[$date][$value->param1_id]=config('shop-info.shop_name');
    }

    for ($i=30;$i>=0;$i--)
    {
        $timeStamp=strtotime('-'.$i.' day');
        $date=$jdf->tr_num($jdf->jdate('Y-n-j',$timeStamp));

        if(array_key_exists($date,$changes))
        {
            foreach ($variationParams as $key=>$value)
            {
                $size=array_key_exists($value->param1_id,$price) ? sizeof($price[$value->param1_id]) :0;
                $points[$date]=replace_number($date);
                if(array_key_exists($value->param1_id,$changes[$date]))
                {
                    $param1[$value->param1_id]=getVariationParamData($value);
                    $price[$value->param1_id][$size]['y']=$changes[$date][$value->param1_id];
                    if($changes[$date][$value->param1_id]==0)
                    {
                        $price[$value->param1_id][$size]['y']=$price[$value->param1_id][($size-1)]['y'];
                        $price[$value->param1_id][$size]['price']=0;
                        $price[$value->param1_id][$size]['has_product']='no';
                        $price[$value->param1_id][$size]['color']='grey';

                        $zone_size=array_key_exists($value->param1_id,$zone) ? sizeof($zone[$value->param1_id]) : 0;
                        $zone[$value->param1_id][$zone_size]=['value'=>$size];

                        if(sizeof($zone[$value->param1_id])==1 && $i==0)
                        {
                            $zone[$value->param1_id][($zone_size+1)]['value']=$zone[$value->param1_id][$zone_size]['value'];
                            $zone[$value->param1_id][($zone_size+1)]['color']='gray';
                        }
                    }
                    else{
                        $price[$value->param1_id][$size]['price']=$changes[$date][$value->param1_id];
                        $price[$value->param1_id][$size]['has_product']='ok';
                        $price[$value->param1_id][$size]['color']='#00bfd6';
                        $price[$value->param1_id][$size]['seller']=config()->get('shop-info.shop_name');

                        if(array_key_exists($value->param1_id,$zone))
                        {
                            $first=sizeof($zone[$value->param1_id])-1;
                            $end=$zone[$value->param1_id][$first];

                            if($price[$value->param1_id][($size-1)]['price']==0)
                            {
                                $zone[$value->param1_id][sizeof($zone[$value->param1_id])]=['value'=>$size,'color'=>'gray'];
                            }
                        }
                    }
                }
                else{
                    if(array_key_exists($value->param1_id,$price) && array_key_exists(($size-1),$price[$value->param1_id]))
                    {

                        $param1[$value->param1_id]=getVariationParamData($value);
                        if($price[$value->param1_id][($size-1)]['price']==0)
                        {
                            $price[$value->param1_id][$size]['y']=$price[$value->param1_id][($size-1)]['y'];
                            $price[$value->param1_id][$size]['price']=0;
                            $price[$value->param1_id][$size]['has_product']='no';
                            $price[$value->param1_id][$size]['color']='grey';

                            $zone_size=array_key_exists($value->param1_id,$zone) ? sizeof($zone[$value->param1_id]) : 0;
                            $zone[$value->param1_id][$zone_size]=['value'=>$size,'color'=>'gray'];
                        }
                        else{
                            $price[$value->param1_id][$size]['y']=$price[$value->param1_id][($size-1)]['y'];
                            $price[$value->param1_id][$size]['price']=$price[$value->param1_id][($size-1)]['price'];
                            $price[$value->param1_id][$size]['has_product']='ok';
                            $price[$value->param1_id][$size]['color']='#00bfd6';
                            $price[$value->param1_id][$size]['seller']=config()->get('shop-info.shop_name');
                            if(array_key_exists($value->param1_id,$zone))
                            {
                                $first=sizeof($zone[$value->param1_id])-1;
                                $end=$zone[$value->param1_id][$first];

                                if($price[$value->param1_id][($size-1)]['price']==0)
                                {
                                    $zone[$value->param1_id][sizeof($zone[$value->param1_id])]=['value'=>$size,'color'=>'gray'];
                                }
                            }
                        }

                    }
                }
            }
        }
        else if(sizeof($price)>0){
            $points[$date]=replace_number($date);

            foreach ($variationParams as $key=>$value){
                $size=array_key_exists($value->param1_id,$price) ? sizeof($price[$value->param1_id]) :0;

                if(array_key_exists($value->param1_id,$price) && array_key_exists(($size-1),$price[$value->param1_id]))
                {
                    $param1[$value->param1_id]=getVariationParamData($value);
                    if($price[$value->param1_id][($size-1)]['price']==0)
                    {
                        $price[$value->param1_id][$size]['y']=$price[$value->param1_id][($size-1)]['y'];
                        $price[$value->param1_id][$size]['price']=0;
                        $price[$value->param1_id][$size]['has_product']='no';
                        $price[$value->param1_id][$size]['color']='grey';

                        if (array_key_exists($value->param1_id,$zone))
                        {
                            $first=sizeof($zone[$value->param1_id])-1;
                            $end=$zone[$value->param1_id][$first];

                            if($price[$value->param1_id][($size-1)]['price']==0)
                            {
                                $zone[$value->param1_id][sizeof($zone[$value->param1_id])]=['value'=>$size,'color'=>'gray'];
                            }
                        }

                    }
                    else{
                        $price[$value->param1_id][$size]['y']=$price[$value->param1_id][($size-1)]['y'];
                        $price[$value->param1_id][$size]['price']=$price[$value->param1_id][($size-1)]['price'];
                        $price[$value->param1_id][$size]['has_product']='ok';
                        $price[$value->param1_id][$size]['color']='#00bfd6';
                        $price[$value->param1_id][$size]['seller']=config()->get('shop-info.shop_name');

                    }
                }
            }
        }
    }

    $i=0;
    foreach ($points as $key=>$value)
    {
        $points[$i]=$value;
        unset($points[$key]);
        $i++;
    }

    $j=0;
    foreach ($price as $key=>$value)
    {
        $price[$j]=$value;
        unset($price[$key]);
        $j++;
    }

    $x=0;
    foreach ($param1 as $key=>$value)
    {
        $param1[$x]=$value;
        unset($param1[$key]);
        $x++;
    }

    $array['price']=$price;
    $array['points']=$points;
    $array['param1']=$param1;
    $array['zone']=$zone;
    $array['paramName']=$paramName;
    return $array;
}
