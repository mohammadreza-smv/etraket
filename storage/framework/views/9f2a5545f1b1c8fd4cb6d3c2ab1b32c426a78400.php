<v-expansion-panel-header>
    <div class="header_box">

        <div>
            مرسوله <?php echo e(replace_number($i)); ?> از <?php echo e(replace_number(get_submission_count($send_order_data,$send_type))); ?>

            <span>(<?php echo e(replace_number(sizeof($data))); ?> کالا)</span>
        </div>

        <?php if(array_key_exists('send_methods',$send_order_data)): ?>
            <div>
                نحوه ارسال
                <span><?php echo e($send_order_data['send_methods'][$sending_method]['send_type_name']); ?></span>
            </div>
        <?php endif; ?>

        <div>
            ارسال از
            <span>
                <?php if($sending_time==0): ?>
                    آماده ارسال
                <?php else: ?>
                    <?php echo e(replace_number($sending_time)); ?> روز کاری
                <?php endif; ?>
             </span>
        </div>

        <?php if(array_key_exists('send_methods',$send_order_data)): ?>
            <div>
                هزینه ارسال
                <span>
                    <?php if($submission_info['price_type']==0): ?>

                        <?php if($submission_info['sending_price']==0): ?>
                            رایگان
                        <?php else: ?>
                            <?php echo e(replace_number(number_format($submission_info['sending_price'])).' تومان'); ?>

                        <?php endif; ?>

                    <?php else: ?>
                        پس کرایه
                    <?php endif; ?>
                </span>
            </div>
        <?php endif; ?>


    </div>
</v-expansion-panel-header>

<v-expansion-panel-content>
    <v-slide-group
        multiple
        show-arrows
    >

        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <v-slide-item  :key="<?php echo e($key); ?>">
                <div class="product_info_box swiper-slide">

                    <?php
                    $product=$send_order_data['products'][1][$value]['product'];
                    ?>

                    <img src="<?php echo e(url('files/thumbnails/'.$product->image_url)); ?>">

                    <p class="product_title"><?php echo e($product->title); ?></p>

                    <?php if($send_order_data['products'][1][$key]->price_params!=null): ?>

                        <?php $__currentLoopData = $send_order_data['products'][1][$key]->price_params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param_key=>$param_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <p class="product_color">
                                <?php if(array_key_exists('title',$param_value)): ?>
                                    <?php echo e($param_value['title']); ?> :
                                <?php endif; ?>
                                <?php echo e($param_value['value']); ?>

                            </p>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php endif; ?>

                </div>
            </v-slide-item>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </v-slide-group>
</v-expansion-panel-content>
<?php /**PATH /home/teraketc/AppCode/modules/cart/resource/views/shipping/order_products.blade.php ENDPATH**/ ?>