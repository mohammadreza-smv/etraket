<?php $__env->startSection('content'); ?>
    <div class="user-panel">
        <?php echo $__env->yieldContent('panel-content'); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/themes/theme1/layouts/mobile/user-panel.blade.php ENDPATH**/ ?>