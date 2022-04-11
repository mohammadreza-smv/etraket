<?php
  $args=[];
  $args['title']='جزییات سفارش - '.replace_number($order->order_id);
?>

<x-panel-box :args="$args">

    @if($order->pay_status=='ok')

        <v-btn color="error">
            <a target="_blank" style="color:white;text-decoration:none" href="{{ url('admin/order/'.$order->id.'/factor') }}">
                فاکتور سفارش
            </a>
        </v-btn>
    @endif

    <?php
      $get_order_detail=get_order_detail($order);
      $j=0;
    ?>

    <table class="table table-bordered order_table_info">


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

</x-panel-box>
