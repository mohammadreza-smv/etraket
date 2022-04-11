<?php $__env->startSection('content'); ?>

    <?php

        $login=Auth::check() ? 'true' : 'false';

        $shop_product_url=shop_product_url_theme();

    ?>

    <mobile-shopping-cart
        :cart_data="<?php echo e(json_encode($cart_data)); ?>"
        :login_status="<?php echo e($login); ?>"
        shop_product_url="<?php echo e($shop_product_url); ?>"
    >

        <template v-slot:loading_box>
            <a href="<?php echo e(url('')); ?>">
                <img  src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="loading-logo">
            </a>
        </template>

    </mobile-shopping-cart>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/cart/resource/views/mobile/cart_products.blade.php ENDPATH**/ ?>