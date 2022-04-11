<?php $__env->startSection('content'); ?>
    <mobile-filter-list
        cat_id="<?php echo e(isset($category) ? $category->id : 0); ?>"
        :max_price="<?php echo e($result['max_price']); ?>"
        cat_name="<?php echo e(isset($category) ? $category->name : 'جست و جو'); ?>"
    >

        <template v-slot:layout="{product}">

            <mobile-product-box :product="product" product_url="<?php echo e(shop_product_url_theme()); ?>">
                <template v-slot:begin-search-product-box>
                    <?php echo $__env->make('position_view',['name'=>'begin_search_product_box','args'=>['show'=>'horizontal']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </template>
            </mobile-product-box>

        </template>

        <template v-slot:product-list>

            <?php if(isset($before_filter)): ?>

                <?php echo $__env->make($before_filter, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php $__currentLoopData = $result['product']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product_div">

                    <?php echo $__env->make('position_view',['name'=>'begin_search_product_box','args'=>['show'=>'horizontal']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="product_info_div">

                        <div class="image_box">
                            <?php if($product['status']==1 && $product->firstProductPrice!=null): ?>
                                <?php if($product->firstProductPrice['price1']!=$product->firstProductPrice['price2']): ?>

                                    <?php
                                        $d=getDiscountValue($product->firstProductPrice['price1'],$product->firstProductPrice['price2']);
                                    ?>
                                    <div>
                                           <span class="discount-badge">
                                               <?php echo e('٪'.replace_number($d)); ?>

                                           </span>
                                    </div>

                                <?php endif; ?>
                            <?php endif; ?>
                            <img class="<?php echo e($product['status']==-1 ? 'stop-production-img' : ''); ?>" src="<?php echo e(url('files/thumbnails/'.$product['image_url'])); ?>">

                        </div>

                        <div class="product-info">
                            <a class="router-link" href="<?php echo e(shop_product_url($product)); ?>">
                                <p class="product-title"><?php echo e($product['title']); ?></p>
                            </a>

                            <?php if($product['status']==1 && $product->firstProductPrice!=null): ?>
                                <div class="price">
                                    <div class="discount_div">
                                        <?php if($product->firstProductPrice['price1']!=$product->firstProductPrice['price2']): ?>
                                            <del>
                                                <?php echo e(replace_number(number_format($product->firstProductPrice['price1']))); ?>

                                            </del>
                                        <?php endif; ?>

                                    </div>

                                    <span><?php echo e(replace_number(number_format($product->firstProductPrice['price2']))); ?> تومان</span>
                                </div>

                            <?php else: ?>
                                <div class="product_status">
                                    <div>
                                        <p class="line"></p>
                                        <?php if($product['status']==0): ?>
                                            <span>ناموجود</span>
                                        <?php elseif($product['status']==-1): ?>
                                            <span>توقف تولید</span>
                                        <?php else: ?>
                                            <span>ناموجود</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            <?php if(sizeof($result['product'])===0): ?>
                <div class="not_fount_product_message">
                        محصولی برای نمایش یافت نشد
                </div>
            <?php endif; ?>

        </template>

    </mobile-filter-list>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/themes/theme1/views/mobile/cat_product.blade.php ENDPATH**/ ?>