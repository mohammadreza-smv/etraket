<?php $__env->startSection('content'); ?>

    <div>

        <order-steppers step="2">

            <template v-slot:header>
                <img src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="shop_icon">
            </template>

        </order-steppers>

        <mobile-payment-box price="<?php echo e(get_price($send_order_data['final_price'][1][$send_type])); ?>" token="<?php echo e(csrf_token()); ?>">

            <template v-slot:message>
                <?php if(Session::has('error')): ?>
                    <v-alert type="error"><?php echo e(Session::get('error')); ?></v-alert>
                <?php endif; ?>
            </template>

            <template slot="factor">
                <?php if ($__env->exists('cart::checkout-items')) echo $__env->make('cart::checkout-items', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </template>

            <template v-slot:paymentitems>
                <v-radio :value="1" label="پرداخت اینترنتی (آنلاین با تمامی کارت های بانکی)"></v-radio>
            </template>

            <template v-slot:content>
                <div>
                    <h4>خلاصه سفارش</h4>
                </div>

                <?php if ($__env->exists('cart::mobile.checkout-products')) echo $__env->make('cart::mobile.checkout-products', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('position_view',['name'=>'payment_page',
                    'args'=>[
                        'order_price'=>$send_order_data['final_price'][1][$send_type]]
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </template>

        </mobile-payment-box>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('cart::layouts.order', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/cart/resource/views/mobile/shipping/payment.blade.php ENDPATH**/ ?>