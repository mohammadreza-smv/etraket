<?php $__env->startSection('content'); ?>




    <div>
        <?php echo $__env->make('backend-theme::breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div>
            <p style="padding-top:100px;text-align:center;font-size:50px">
                <span class="fa fa-exclamation"></span>
            </p>
            <p style="text-align:center;padding-bottom:80px">شما دسترسی لازم برای عملیات جاری را ندارید</p>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/users/resource/views/admin/403.blade.php ENDPATH**/ ?>