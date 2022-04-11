<?php if(!isset($show)): ?>
    <?php  $show='vertical'; ?>
<?php endif; ?>

<?php if(isset($product)): ?>
    <product-offers-time :product="<?php echo e($product); ?>" show="<?php echo e($show); ?>"></product-offers-time>
<?php else: ?>
    <product-offers-time :product="product" show="<?php echo e($show); ?>"></product-offers-time>
<?php endif; ?>

<?php /**PATH /home2/teraketc/AppCode/modules/incredibleOffers/resource/views/product/timer.blade.php ENDPATH**/ ?>