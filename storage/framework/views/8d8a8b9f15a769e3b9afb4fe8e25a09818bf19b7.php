<?php $__env->startSection('content'); ?>

    <forgot-password>
        <template v-slot:before-forgot-form>
            <a href="<?php echo e(url('')); ?>">
                <img  src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="shop_logo">
            </a>
        </template>
    </forgot-password>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("users::auth.layouts.$layout", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/users/resource/views/auth/passwords/email.blade.php ENDPATH**/ ?>