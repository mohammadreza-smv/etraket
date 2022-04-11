<?php if(!isset($filter_array)): ?>
    <?php $filter_array=[] ?>
<?php endif; ?>

<?php if(!isset($filters)): ?>
    <?php
       $filters=[];
       $product_filters=[];
    ?>
<?php endif; ?>

<select-filter-for-product-item
    :item="slotProps.item"
    default_component="<?php echo e($path); ?>"
    :filter_array="<?php echo e(json_encode($filter_array)); ?>"
    :filters="<?php echo e(json_encode($filters)); ?>"
    :product_filters="<?php echo e(json_encode($product_filters)); ?>"
>

</select-filter-for-product-item>
<?php /**PATH /home2/teraketc/AppCode/modules/filters/resource/views/item_filters.blade.php ENDPATH**/ ?>