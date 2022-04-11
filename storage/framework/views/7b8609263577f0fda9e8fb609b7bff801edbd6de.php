<?php if(sizeof($value->events)>0): ?>
    <div style="margin-top: 20px">
        <p>رویداد های مرسوله</p>
        <table class="table table-bordered event-table" >
            <thead>
            <tr>
                <th>ردیف</th>
                <th>تغییر از وضعیت</th>
                <th>به وضعیت</th>
                <th>زمان تغییر وضعیت</th>
                <th>توسط</th>
            </tr>
            </thead>

            <?php $__currentLoopData = $value->events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e(replace_number(++$k)); ?></td>
                    <td>
                        <?php if(array_key_exists($event->from,$OrderStatus)): ?>
                            <?php echo e(getOrderStatus($event->from)); ?>

                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(array_key_exists($event->to,$OrderStatus)): ?>
                            <?php echo e(getOrderStatus($event->to)); ?>

                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                            $e=explode(' ',$event->created_at);
                            $e2=explode('-',$e[0]);
                        ?>
                        <?php echo e(replace_number($Jdf->gregorian_to_jalali($e2[0],$e2[1],$e2[2],'-'))); ?>

                    </td>
                    <td>
                        <?php if($event->user): ?>
                            <a href="<?php echo e(url('admin/users/'.$event->user->id)); ?>" class="router-link" style="color: black;text-decoration:none">
                                <?php echo e($event->user->name); ?>

                            </a>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php if(!empty($event->tozihat) && $event->tozihat!=="null"): ?>
                    <tr>
                        <td colspan="5" style="text-align: right">
                            <span>توضیحات : </span>
                            <?php echo e($event->tozihat); ?>

                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    </div>
<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/orders/resource/views/submission/submission-events.blade.php ENDPATH**/ ?>