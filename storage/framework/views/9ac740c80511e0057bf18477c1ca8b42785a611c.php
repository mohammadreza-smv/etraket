<?php
$property='param'.$num.'_id';
$relation='param'.$num;
$selected=false;
?>

<?php if(!isset($type) || $type!='select'): ?>
    <?php if($num==2): ?>
        <?php $__currentLoopData = $product->PriceVariation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($param1_id==$variation->param1_id && $param2_id==$variation->param2_id && !$selected): ?>
                <?php if($variation->$relation): ?>
                    <?php $selected=true; ?>
                    <div class="info_item_product">
                        <div>
                            <v-icon>mdi-shield-star</v-icon>
                            <?php echo e($variation->$relation->name); ?>

                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <?php $__currentLoopData = $product->PriceVariation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($price_variation->param1_id==$variation->param1_id  && !$selected): ?>
                <?php if($variation->$relation): ?>
                    <?php $selected=true; ?>
                    <div class="info_item_product">
                        <div>
                            <v-icon>mdi-shield-star</v-icon>
                            <?php echo e($variation->$relation->name); ?>

                        </div>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/warranty/resource/views/variationItems.blade.php ENDPATH**/ ?>