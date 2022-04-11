<?php $__env->startSection('content'); ?>

   <auth-login-box>
       <template v-slot:before-login-form>
           <a href="<?php echo e(url('')); ?>">
               <img  src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="shop_logo">
           </a>
       </template>
   </auth-login-box>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("users::auth.layouts.$layout", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/users/resource/views/auth/login.blade.php ENDPATH**/ ?>