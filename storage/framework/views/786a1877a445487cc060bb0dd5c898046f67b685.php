
<?php
\App\Lib\GridView::showTable([
    'dataProvider'=>$orders,
    'columns'=>[
        [
            'label'=>'تصویر محصول',
            'attr'=>function($value){
                if($value->product){
                    $src=url('files/thumbnails/'.$value->product->image_url);
                    return '<img src="'.$src.'" style="width: 100px;margin:10px"/>';
                }
                else{
                    return  '';
                }
            },
            'html'=>true
        ],
        [
            'label'=>'عنوان محصول',
            'attr'=>function($value){
                if($value->product){
                    return $value->product->title;
                }
                else{
                    return  '';
                }
            },
        ],
        [
            'label'=>'مبلغ فروش',
            'attr'=>function($value){
                return replace_number(number_format($value->product_price2));
            },
        ],
        [
            'label'=>'زمان ثبت',
            'attr'=>function($value){
                $jdf=new \App\Lib\Jdf();
                $time=$jdf->jdate('H:i:s',$value->order_time).' / '.$jdf->jdate('Y-n-j',$value->order_time);
                return e($time);
            },
        ],
        [
            'label'=>'وضعیت',
            'attr'=>function($value){
                $class=$value->send_status<=0 ? 'alert-danger' : 'alert-success';
                return '<div class="'.$class.'">'.e(getOrderStatus($value->send_status)).'</div>';
            },
        ],
    ],
    'tableLabel'=>'سفارش',
    'actions'=>[
        function($model){
            $url=url('sellers/panel/orders/'.$model->id);
            return '<a href="'.$url.'" class="router-link"><v-icon>mdi-eye</v-icon></a> ';
        }
    ]
],true,true);
?>
<?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/panel/orders/list.blade.php ENDPATH**/ ?>