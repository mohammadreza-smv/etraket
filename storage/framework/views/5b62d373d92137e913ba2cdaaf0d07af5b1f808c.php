<?php if(!isset($type) || $type=='select'): ?>

    <?php
        $property='param'.$num.'_id';
        $relation='param'.$num;
        $param_key='param'.$num.'_type'
    ?>
    <div style="padding-bottom: 20px;padding-top:20px">
        <?php if($product->PriceVariation[0]->$relation): ?>
            <span>انتخاب <?php echo e($product->PriceVariation[0]->$relation->variation_name); ?></span>
            <?php
                $select_id=$num=="1" ? $param1_id : $param2_id;
            ?>

            <select-item
                :price_variation="<?php echo e(json_encode($product->PriceVariation)); ?>"
                property="<?php echo e($property); ?>"
                param_key="<?php echo e($param_key); ?>"
                num="<?php echo e($num); ?>"
                relation="<?php echo e($relation); ?>"
                select_id="<?php echo e($select_id); ?>"
            ></select-item>
        <?php endif; ?>
    </div>

<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/priceVariation/resource/views/variationItems.blade.php ENDPATH**/ ?>