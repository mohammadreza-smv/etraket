<?php
$get_order_detail=get_order_detail($order);
$j=0;

if(defined('view_type') && view_type=='mobile'){

    $jdf=new \App\Lib\Jdf();

    $firstData=[
        [
            'label'=>'تاریخ ثبت',
            'value'=>$jdf->jdate('j F Y',$order->created_at)
        ]
    ];

    $get_order_detail=array_merge($firstData,$get_order_detail);
}

?>
<table class="order-table-info">


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
<?php /**PATH /home/teraketc/AppCode/modules/orders/resource/views/userpanel/order-global-info.blade.php ENDPATH**/ ?>