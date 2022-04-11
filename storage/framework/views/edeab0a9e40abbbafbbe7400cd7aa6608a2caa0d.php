<?php if(isset($product)): ?>
    <shop-detail :product="<?php echo e($product); ?>"></shop-detail>
<?php else: ?>
    <shop-detail :product="product"></shop-detail>
<?php endif; ?>

<?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/product/shop-detail.blade.php ENDPATH**/ ?>