<?php $__env->startSection('content'); ?>

    <div class="row">

        <div class="col-3">
            <?php echo $__env->make('user_panel_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-9" style="padding-right: 0px">

            <div class="profile_content">
                <?php echo $__env->yieldContent('panel-content'); ?>
            </div>

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/themes/theme1/layouts/user-panel.blade.php ENDPATH**/ ?>