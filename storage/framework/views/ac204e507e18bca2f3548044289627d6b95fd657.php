<?php if(isset($product)): ?>
    <comparison-checkbox
       id="<?php echo e($product->id); ?>"
       title="<?php echo e($product->title); ?>"
       image_url="<?php echo e($product->image_url); ?>"
    ></comparison-checkbox>
<?php else: ?>
    <comparison-checkbox
        :id="product.id"
        :title="product.title"
        :image_url="product.image_url"
    ></comparison-checkbox>
<?php endif; ?>

<?php /**PATH /home2/teraketc/AppCode/modules/productComparison/resource/views/product-list-check-box.blade.php ENDPATH**/ ?>