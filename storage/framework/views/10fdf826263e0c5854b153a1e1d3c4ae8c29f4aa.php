<?php
   $args=[];
   $args['title']=isset($title) ? $title : 'مدیریت سفارشات';
   $args['route']='admin/orders';
   if(isset($trash_orders_count)){
       $args['trashCount']=$trash_orders_count;
   }
   $args['routeParam']='سفارش';
   $args['remove_new_record']=true;
?>

<?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <?php
    \App\Lib\GridView::showTable([
        'dataProvider'=>$orders,
        'columns'=>[
            [
                'label'=>'شماره سفارش',
                'attr'=>function($value){
                    $style=($value->order_read=='no') ? 'color: red' : '';
                    return '<span style="'.$style.'">'.e(replace_number($value->order_id )).'</span>';
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
                    return '<span class="alert alert-primary" style="padding: 5px 10px;border-radius:0px;">'.e(get_price($value['price'])).'</span>';
                },
                'html'=>true
            ],
            [
                'label'=>'وضعیت سفارش',
                'attr'=>function($value){
                    if($value['pay_status']=='awaiting_payment'){
                        return '<span class="alert alert-warning" style="padding: 5px 10px;border-radius:0px;">در انتظار پرداخت</span>';
                    }
                    else if($value['pay_status']=='ok'){
                        return ' <span class="alert alert-success"  style="padding: 5px 10px;border-radius:0px;">پرداخت شده</span>';
                    }
                    else if($value['pay_status']=='canceled'){
                        return '<span class="alert alert-warning"  style="padding: 5px 10px;border-radius:0px;">لغو شده</span>';
                    }
                    else{
                        return  '<span class="alert alert-danger"  style="padding: 5px 10px;border-radius:0px;">خطا در اتصال به درگاه</span>';
                    }
                },
                'html'=>true
            ]
        ],
        'route_param'=>'orders',
        'tableLabel'=>'سفارش',
        'actions'=>[
            function($value){
                $url=url('admin/orders/'.$value->id);
                return '<a href="'.$url.'" class="router-link"><v-icon>mdi-eye-outline</v-icon></a> ';
            }
        ]
    ],true);
    ?>

    <?php if(!isset($removePaginate)): ?>
        <?php echo e($orders->links()); ?>

    <?php endif; ?>


 <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/orders/resource/views/order-list.blade.php ENDPATH**/ ?>