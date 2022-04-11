<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت مرسوله ها','url'=>url('admin/orders/submissions')],
             ['title'=>'جزییات مرسوله','url'=>url('admin/orders/submissions/'.$submission[0]->id)]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if ($__env->exists('orders::order-submission')) echo $__env->make('orders::order-submission', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/orders/resource/views/submission-show.blade.php ENDPATH**/ ?>