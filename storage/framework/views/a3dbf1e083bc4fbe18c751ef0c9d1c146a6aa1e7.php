<?php $__env->startSection('content'); ?>

    <div>
        <div>
            <order-steppers step="3">

                <template v-slot:header>
                    <img src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="shop_icon">
                </template>

            </order-steppers>
        </div>

        <div style="width: 99%;margin: auto">
            <div class="order-detail">

                <?php if($detail['status']=='error'): ?>
                    <div class="pay-status">
                        <v-icon>mdi-alert</v-icon>
                        <p>پرداخت انجام نشد</p>
                        <p>در صورتی که از حساب شما مبلغ سفارش کسر شده باشد طی ساعات آینده از طرف بانک به حساب شما برگشت داده میشود</p>

                    </div>
                <?php else: ?>
                    <div class="pay-status">
                        <p>سفارش <span class="order-id">
                            <?php if(is_array($detail) && array_key_exists('order',$detail)): ?>
                                    <?php echo e(replace_number($detail['order']->order_id)); ?>

                                <?php endif; ?>
                        </span> با موفقیت پرداخت و در سیستم ثبت شده</p>
                        <p>
                            پرداخت با موفقیت انجام شد و سفارش شما در زمان تعیین شده ارسال خواهد شده
                        </p>
                        <p>
                            از اینکه <?php echo e(config('shop-info.shop_name')); ?> را برای خرید انتخاب کردید از شما سپاسگذاریم
                        </p>
                    </div>
                <?php endif; ?>


            </div>

            <?php if($detail['status']=='ok'): ?>
                <div class="order-detail">
                    <div style="margin:30px 20px">

                        <?php if(array_key_exists('order_link',$detail)): ?>

                            <a target="_blank" style="color: white;text-decoration: none" href="<?php echo e($detail['order_link']); ?>">
                                <v-btn color="error">
                                    جزییات سفارش
                                </v-btn>
                            </a>

                        <?php endif; ?>

                        <?php if(array_key_exists('view',$detail)): ?>
                            <?php if ($__env->exists($detail['view'],['order'=>$detail['order']])) echo $__env->make($detail['view'],['order'=>$detail['order']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('cart::layouts.order', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/cart/resource/views/mobile//shipping/verify.blade.php ENDPATH**/ ?>