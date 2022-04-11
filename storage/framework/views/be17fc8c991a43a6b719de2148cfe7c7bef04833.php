<?php $__env->startSection('content'); ?>

    <div>

        <order-steppers>

            <template v-slot:header>
                <img src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="shop_icon">
            </template>

        </order-steppers>

        <order-products type="mobile">

            <?php if(isset($address)): ?>
                <template v-slot:header>
                    <mobile-address-list :data="<?php echo e(json_encode($address)); ?>"></mobile-address-list>
                </template>
            <?php endif; ?>

            <template v-slot:checkout-items>

                <?php
                $total_price=Session::get('total_price',0);
                $final_price=Session::get('final_price',0);
                $count=Session::get('product_count',0);
                ?>
                <ul style="padding:10px">
                    <li>
                        <div>
                            <span>مبلغ کل </span>
                            <span>(<?php echo e(replace_number($count)); ?>) کالا</span>
                        </div>
                        <span class="left"><?php echo e(replace_number(number_format($total_price))); ?> تومان</span>
                    </li>

                    <li>
                        <span>هزینه ارسال</span>
                        <span class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="هزینه ارسال مرسولات می‌تواند وابسته به شهر و آدرس گیرنده متفاوت باشد. در صورتی که هر یک از مرسولات حداقل ارزشی برابر با ۱۵۰هزار تومان داشته باشد، آن مرسوله بصورت رایگان ارسال می‌شود."></span>
                        <span class="left" id="total_send_order_price">رایگان</span>
                    </li>

                    <?php
                    $checkoutItems=run_action('checkout_items',[],true);
                    ?>
                    <?php if(is_array($checkoutItems)): ?>
                        <?php $__currentLoopData = $checkoutItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="<?php echo e($item['name']); ?> <?php echo e($item['type']); ?>"  style="display: <?php echo e($item['display']); ?>">
                                <span>تخفیف</span>
                                <span class="left" id="<?php echo e($item['name']); ?>_value">
                                        <?php echo e($item['value']); ?>

                                     </span>
                            </li>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ul>

            </template>
        </order-products>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('cart::layouts.order', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/cart/resource/views/mobile/shipping/set_data.blade.php ENDPATH**/ ?>