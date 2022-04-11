<mobile-other-price-variation :product_id="<?php echo e($product->id); ?>">
    <template v-slot:variation-list-detail="{variation}">
        <?php echo $__env->make('position_view',['name'=>'product_variation_list_params'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </template>
</mobile-other-price-variation>
<?php /**PATH /home/teraketc/AppCode/modules/priceVariation/resource/views/product/mobile-list.blade.php ENDPATH**/ ?>