<?php
    $seller=$price_variation->seller;
    $brand_name=$seller->brand_name;
    config()->set('seller_component','add');
?>
<div>
    <a style="color: black"
        <?php if($seller->id>0): ?> href="<?php echo e(url('seller/'.$seller->id)); ?>"  <?php endif; ?>
        target="_blank" class="info_item_product">
        <div>
            <v-icon>mdi-home</v-icon>
            <?php echo e($brand_name); ?>

        </div>
        <div>
            <v-icon>mdi-chevron-left</v-icon>
        </div>
    </a>
</div>
<?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/product/variation-item.blade.php ENDPATH**/ ?>