<?php
  $args=['title'=>'آخرین سفارشات'];
?>

<x-user-panel-box :args="$args">

    <div class="last-order">
        <?php

          \App\Lib\GridView::showTable([
              'tableCssClass'=>'product_list_table',
              'dataProvider'=>$lastOrder,
              'columns'=>[
                  [
                      'label'=>'شماره سفارش',
                      'attr'=>function($value){
                          return '<span>'.e(replace_number($value->order_id )).'</span>';
                      },
                      'html'=>true
                  ],
                  [
                      'label'=>'زمان ثبت',
                      'attr'=>function($value){
                          $jdf=new \App\Lib\Jdf();
                          $time=$jdf->jdate('H:i:s',$value->created_at).' / '.$jdf->jdate('Y-n-j',$value->created_at);
                          return e($time);
                      },
                      'html'=>true
                  ],
                  [
                      'label'=>'مبلغ سفارش',
                      'attr'=>function($value){
                          return '<span>'.e(get_price($value['price'])).'</span>';
                      },
                      'html'=>true
                  ],
                  [
                      'label'=>'وضعیت سفارش',
                      'attr'=>function($value){
                          if($value['pay_status']=='awaiting_payment'){
                              return '<span>در انتظار پرداخت</span>';
                          }
                          else if($value['pay_status']=='ok'){
                              return ' <span style="color: #00b100">پرداخت شده</span>';
                          }
                          else if($value['pay_status']=='canceled'){
                              return '<span>لغو شده</span>';
                          }
                          else{
                              return  '<span>خطا در اتصال به درگاه</span>';
                          }
                      },
                      'html'=>true
                  ]
              ],
              'actions'=>[
                  function($value){
                      $url=url('user/profile/order/'.$value->id);
                      return '<a href="'.$url.'" class="router-link"><v-icon>mdi-eye-outline</v-icon></a> ';
                  }
              ]
          ],true,true);

        ?>
    </div>

</x-user-panel-box>
