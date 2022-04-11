<product-review>
    <?php $__currentLoopData = $review; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(empty($value->title)): ?>
            <div class="review_tozihat">
                <h4>نقد و بررسی تخصصی</h4>
                <?php echo $value->tozihat; ?>

            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $review; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!empty($value->title)): ?>
            <div class="item_row" id="review_box_<?php echo e($value->id); ?>">
                <button class="expert_button" onclick='vm.$root.$emit("change_review_box_status","<?php echo e($value->id); ?>")'>
                    <v-icon class="plus">mdi-plus</v-icon>
                    <v-icon class="minus">mdi-minus</v-icon>
                </button>
                <h3><?php echo e($value->title); ?></h3>
                <div class="content">
                    <?php
                        $find='style="width:100%"';
                        $replace='class="review_image"';
                        $tozihat=str_replace($find,$replace,$value->tozihat);
                    ?>
                    <?php echo $tozihat; ?>

                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</product-review>
<?php /**PATH /home/teraketc/AppCode/modules/review/resource/views/show.blade.php ENDPATH**/ ?>