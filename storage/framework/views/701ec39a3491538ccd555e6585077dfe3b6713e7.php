<?php

$detect=new \App\Lib\Mobile_Detect();

?>

<?php if($detect->isMobile() || $detect->isTablet()): ?>
    <?php $layout='mobile-app'; ?>
<?php else: ?>
    <?php $layout='app'; ?>
<?php endif; ?>



<?php $__env->startSection('content'); ?>

    <div class="error_content">

        <?php if($layout=='app'): ?>
            <h3>صفحه‌ای که دنبال آن بودید پیدا نشد!</h3>
        <?php else: ?>
            <h4>صفحه‌ای که دنبال آن بودید پیدا نشد!</h4>
        <?php endif; ?>
        <a href="<?php echo e(url('/')); ?>" class="btn btn-success">صفحه اصلی</a>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.'.$layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/themes/theme1/views/404.blade.php ENDPATH**/ ?>