<?php
$get_submission_detail=get_submission_detail($value);
$j=0;
?>
<table class="table table-bordered order_table_info">


    <?php for($i=0;$i<ceil(sizeof($get_submission_detail)/2);$i++): ?>
        <tr>
            <td <?php if(!array_key_exists(($j+1),$get_submission_detail)): ?> colspan="2" style="text-align: center" <?php endif; ?>>
                <?php echo e($get_submission_detail[$j]['label']); ?>

                <span> <?php echo e($get_submission_detail[$j]['value']); ?></span>
            </td>
            <?php $j++ ?>
            <?php if(array_key_exists($j,$get_submission_detail)): ?>
                <td>
                    <?php echo e($get_submission_detail[$j]['label']); ?>

                    <span> <?php echo e($get_submission_detail[$j]['value']); ?></span>
                </td>
                <?php $j++ ?>
            <?php endif; ?>

        </tr>
    <?php endfor; ?>

</table>
<?php /**PATH /home2/teraketc/AppCode/modules/orders/resource/views/submission/detail.blade.php ENDPATH**/ ?>