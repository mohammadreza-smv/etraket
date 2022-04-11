<li>
    <div>
        <span>مبلغ کل </span>
        <span>(<?php echo e(replace_number(sizeof($send_order_data['products'][1]))); ?>) کالا</span>
    </div>
    <span class="left"><?php echo e(get_price($send_order_data['cart_price'][1])); ?> </span>
</li>

<li>
    <span>هزینه ارسال</span>
    <span class="left" id="total_send_order_price">
               <?= get_send_order_amount($send_type,$send_order_data)  ?>
        </span>
</li>

<?php if(is_array($send_order_data['checkoutItems'])): ?>
    <?php $__currentLoopData = $send_order_data['checkoutItems']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="<?php echo e($item['name']); ?>"  style="display: <?php echo e($item['display']); ?>">
            <span><?php echo e($item['title']); ?></span>
            <span class="left" id="<?php echo e($item['name']); ?>_value">
                         <?php echo e($item['value']); ?>

                    </span>
        </li>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /home2/teraketc/AppCode/modules/cart/resource/views/checkout-items.blade.php ENDPATH**/ ?>