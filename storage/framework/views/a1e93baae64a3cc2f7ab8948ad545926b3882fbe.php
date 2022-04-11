<?php if(isset($product)): ?>
    <product-color-list :product="<?php echo e($product); ?>"></product-color-list>
<?php else: ?>
    <product-color-list :product="product"></product-color-list>
<?php endif; ?>

<?php /**PATH /home/teraketc/AppCode/modules/colors/resource/views/product/color_list.blade.php ENDPATH**/ ?>