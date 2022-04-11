
<?php if(sizeof($products)>0): ?>

    <div class="product_box">

        <?php
            if(defined('cat_name')){
                $title=str_replace(':name',cat_name,$title);
            }
        ?>
        <?php if(!empty($title)): ?>
            <div class="box_title">
                <h6><?php echo e($title); ?></h6>
            </div>
        <?php endif; ?>

        <v-slide-group
            multiple
            show-arrows
        >
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $price1=$product->price+$product->discount_price;
                ?>
                <v-slide-item  :key="<?php echo e($key); ?>">
                    <a class="router-link" data-component="product-page-skeleton"  href="<?php echo e(shop_product_url($product)); ?>">
                        <div class="product">
                            <div class="product_img_div">
                                <img src="<?php echo e(url('files/thumbnails/'.$product->image_url)); ?>">
                            </div>

                            <p class="title">
                                <?php if(strlen($product->title)>40): ?>
                                    <?php echo e(mb_substr($product->title,0,40).' ... '); ?>

                                <?php else: ?>
                                    <?php echo e($product->title); ?>

                                <?php endif; ?>
                            </p>
                            <div class="discount_price">

                                <?php if(!empty($product->discount_price)): ?>

                                    <del >
                                        <?php echo e(replace_number(number_format($price1))); ?>

                                    </del>
                                    <span class="discount-badge">
                                           <?php
                                        $d=($product->price/$price1)*100;
                                        $d=100-$d;
                                        $d=round($d);
                                        ?>
                                           ٪<?php echo e(replace_number($d)); ?>

                                     </span>
                                <?php endif; ?>

                            </div>

                            <p class="price">
                                <?php echo e(replace_number(number_format($product->price)).' تومان'); ?>

                            </p>
                        </div>
                    </a>
                </v-slide-item>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </v-slide-group>

    </div>
<?php endif; ?>

<?php /**PATH /home/teraketc/AppCode/themes/theme1/views/horizontal_product_list_view.blade.php ENDPATH**/ ?>