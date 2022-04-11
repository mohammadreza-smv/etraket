<?php $__env->startSection('content'); ?>

    <compare-box>
        <p style="padding-top:10px">لیست مقایسه <?php echo e($category->name); ?></p>
        <div class="compare_item_list">

            <div class="compare_box">
                <div class="compare_product_gallery">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="gallery_box">
                            <v-carousel hide-delimiter-background height="180px">
                                <?php if(sizeof($value->Gallery)>0): ?>
                                    <?php $__currentLoopData = $value->Gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2=>$value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <v-carousel-item
                                            key="<?php echo e($key2); ?>"
                                        >
                                            <img src="<?php echo e(url('files/gallery/'.$value2->image_url)); ?>"  class="compare_gallery_pic">
                                        </v-carousel-item>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <v-carousel-item
                                        key="<?php echo e($key); ?>"
                                    >
                                        <img src="<?php echo e(url('files/thumbnails/'.$value->image_url)); ?>"  class="compare_gallery_pic">
                                    </v-carousel-item>
                                <?php endif; ?>
                            </v-carousel>
                            <div class="title">
                                <a onclick="vm.$root.$emit('send_get_request','<?php echo e(shop_product_url($value)); ?>')">
                                    <?php echo e($value->title); ?>

                                </a>
                                <p class="price"><?php echo e(replace_number(number_format($value->price))); ?> تومان</p>
                                <v-btn onclick="vm.$root.$emit('send_get_request','<?php echo e(shop_product_url($value)); ?>')"
                                       color="primary">
                                    مشاهده و خرید محصول
                                </v-btn>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php for($i=sizeof($products);$i<4;$i++): ?>
                        <div class="compare_add">
                            <button class="add" onclick="vm.$root.$emit('show_compare_products')">
                                <p class="fa fa-plus-circle"></p>
                                <p>برای افزودن کالا به لیست مقایسه کلیک کنید</p>
                            </button>
                            <v-btn class="btn btn-dark"
                                    onclick="vm.$root.$emit('show_compare_products')"
                            >
                                افزودن کالا به لیست مقایسه
                            </v-btn>
                        </div>
                    <?php endfor; ?>
                </div>


                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <h5 class="compare_title"><?php echo e($value->title); ?></h5>
                    <ul class="compare_ul">
                        <?php $__currentLoopData = $value->getChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2=>$value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="title"><?php echo e($value2->title); ?></li>
                            <li class="value">
                                <div <?php if(sizeof($products)>0): ?> class="left_border" <?php endif; ?>>
                                    <?php echo strip_tags( get_item_value(0,$products,$value2->id),'<br>'); ?>

                                </div>
                                <div <?php if(sizeof($products)>1): ?> class="left_border" <?php endif; ?>>
                                    <?php echo strip_tags( get_item_value(1,$products,$value2->id),'<br>'); ?>

                                </div>
                                <div <?php if(sizeof($products)>2): ?> class="left_border" <?php endif; ?>>
                                    <?php echo strip_tags( get_item_value(2,$products,$value2->id),'<br>'); ?>

                                </div>
                                <div <?php if(sizeof($products)>3): ?> class="left_border" <?php endif; ?>>
                                    <?php echo strip_tags( get_item_value(3,$products,$value2->id),'<br>'); ?>

                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        </div>

        <compare-product-list :cat_id="<?php echo e($category->id); ?>"></compare-product-list>
    </compare-box>


<?php $__env->stopSection(); ?>



<?php echo $__env->make('front-theme::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/productComparison/resource/views/compare.blade.php ENDPATH**/ ?>