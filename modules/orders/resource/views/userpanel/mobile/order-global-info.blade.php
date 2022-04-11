<?php

   $jdf=new \App\Lib\Jdf();

   $default=[['label'=>'تاریخ ثبت','value'=>$jdf->jdate(' j F Y',$order->created_at) ]];
   $get_order_detail=array_merge($default,get_order_detail($order));
   $j=0;

?>

<table class="order-table-info">

    @for($i=0;$i<ceil(sizeof($get_order_detail)/2);$i++)
        <tr>
            <td @if(!array_key_exists(($j+1),$get_order_detail)) colspan="2" style="text-align: center" @endif>
                {{ $get_order_detail[$j]['label'] }}
                <span> {{ $get_order_detail[$j]['value'] }}</span>
            </td>
            <?php $j++ ?>
            @if(array_key_exists($j,$get_order_detail))
                <td>
                    {{ $get_order_detail[$j]['label'] }}
                    <span> {{ $get_order_detail[$j]['value'] }}</span>
                </td>
                <?php $j++ ?>
            @endif

        </tr>
    @endfor

</table>
