<?php $__env->startSection('content'); ?>

    <auth-register-box shop_name="<?php echo e(config('shop-info.shop_name')); ?>">
        <template v-slot:before-register-form>
            <a href="<?php echo e(url('')); ?>">
                <img  src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="shop_logo">
            </a>
        </template>
    </auth-register-box>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("users::auth.layouts.$layout", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/users/resource/views/auth/register.blade.php ENDPATH**/ ?>