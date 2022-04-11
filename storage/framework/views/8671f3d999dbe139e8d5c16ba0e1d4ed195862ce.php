<?php
  $args=[];
  $args['title']='جزییات سفارش - '.replace_number($order->order_id);
?>

<?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <?php if($order->pay_status=='ok'): ?>

        <v-btn color="error">
            <a target="_blank" style="color:white;text-decoration:none" href="<?php echo e(url('admin/order/'.$order->id.'/factor')); ?>">
                فاکتور سفارش
            </a>
        </v-btn>
    <?php endif; ?>

    <?php
      $get_order_detail=get_order_detail($order);
      $j=0;
    ?>

    <table class="table table-bordered order_table_info">


             <?php for($i=0;$i<ceil(sizeof($get_order_detail)/2);$i++): ?>
                <tr>
                    <td <?php if(!array_key_exists(($j+1),$get_order_detail)): ?> colspan="2" style="text-align: center" <?php endif; ?>>
                        <?php echo e($get_order_detail[$j]['label']); ?>

                        <span> <?php echo e($get_order_detail[$j]['value']); ?></span>
                    </td>
                    <?php $j++ ?>
                    <?php if(array_key_exists($j,$get_order_detail)): ?>
                        <td>
                            <?php echo e($get_order_detail[$j]['label']); ?>

                            <span> <?php echo e($get_order_detail[$j]['value']); ?></span>
                        </td>
                        <?php $j++ ?>
                    <?php endif; ?>

                </tr>
             <?php endfor; ?>

    </table>

 <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php /**PATH /home2/teraketc/AppCode/modules/orders/resource/views/order-detail.blade.php ENDPATH**/ ?>