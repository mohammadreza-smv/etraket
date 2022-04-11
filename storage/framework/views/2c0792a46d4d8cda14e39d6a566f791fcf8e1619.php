<?php $__env->startSection('content'); ?>

    <seller-forgot-password>
        <template slot="login-right-box">

            <div>
                <img src="<?php echo e(url(config('shop-info.shop_icon'))); ?>">
                <h5>به مرکز فروشندگان <?php echo e(config('shop-info.shop_name')); ?> خوش آمدید</h5>
            </div>

        </template>

        <template slot="content">
            <a href="<?php echo e(url('sellers/login')); ?>" class="router-link c-link">
                ورود به پنل فروشندگان
            </a>
        </template>

    </seller-forgot-password>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/auth/passwords/mobile.blade.php ENDPATH**/ ?>