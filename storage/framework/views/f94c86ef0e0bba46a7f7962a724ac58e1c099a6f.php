<other-price-variation :product_id="<?php echo e($product->id); ?>">
    <template v-slot:variation-list-detail="{variation}">
        <?php echo $__env->make('position_view',['name'=>'product_variation_list_params'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </template>
</other-price-variation>
<?php /**PATH /home2/teraketc/AppCode/modules/priceVariation/resource/views/product/list.blade.php ENDPATH**/ ?>