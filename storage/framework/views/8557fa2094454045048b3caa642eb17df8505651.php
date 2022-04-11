<?php $__env->startSection('content'); ?>

    <desktop-filter-list cat_id="<?php echo e(isset($category) ? $category->id : 0); ?>" :max_price="<?php echo e($result['max_price']); ?>">

        <template v-slot:before-filter-list>
            <?php if(isset($before_filter)): ?>
                <?php echo $__env->make($before_filter, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </template>

        <template v-slot:before-product-list>

            <div>
                <?php if(isset($before_products)): ?>
                    <?php echo $__env->make($before_products, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>

            <ul class="list-inline map_ul">
                <li>
                    <a class="router-link" href="<?php echo e(url('/')); ?>">فروشگاه</a>
                    <?php if(isset($category) || (isset($mapLinks) && sizeof($mapLinks)>0)): ?> / <?php endif; ?>
                </li>
                <?php if(isset($category)): ?>
                    <?php if($category->getParent->getParent->name!="-"): ?>
                        <li><a class="router-link" href="<?php echo e(url('main/'.$category->getParent->getParent->url)); ?>"><?php echo e($category->getParent->getParent->name); ?></a> </li>
                    <?php endif; ?>
                    <?php if($category->getParent->name!="-"): ?>
                        <li>  <?php if($category->getParent->getParent->name!="-"): ?>
                                /
                            <?php endif; ?>
                            <a class="router-link" href="<?php echo e(url('search/'.$category->getParent->url)); ?>"><?php echo e($category->getParent->name); ?></a></li>
                    <?php endif; ?>
                    <li>
                        / <a class="router-link" href="<?php echo e(url()->current()); ?>">
                            <?php echo e($category->name); ?>

                        </a>
                    </li>
                <?php endif; ?>

                <?php if(isset($mapLinks)): ?>
                    <?php $__currentLoopData = $mapLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a class="router-link" href="<?php echo e($value['link']); ?>"><?php echo e($value['title']); ?></a>
                            <?php if($key!==(sizeof($mapLinks)-1)): ?> / <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>

        </template>

        <template v-slot:layout="{product}">

           <product-box :product="product" product_url="<?php echo e(shop_product_url_theme()); ?>">
               <template v-slot:begin-search-product-box>
                   <?php echo $__env->make('position_view',['name'=>'begin_search_product_box'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               </template>

               <template v-slot:detail>
                   <?php if(isset($category)): ?>
                       <?php if ($__env->exists('productComparison::product-list-check-box')) echo $__env->make('productComparison::product-list-check-box', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                   <?php endif; ?>
               </template>

               <template v-slot:end-search-product-box>
                   <?php echo $__env->make('position_view',['name'=>'end_search_product_box'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               </template>

           </product-box>

        </template>

        <template v-slot:product-list>

            <?php $__currentLoopData = $result['product']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product_div">

                    <?php echo $__env->make('position_view',['name'=>'begin_search_product_box'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="image_div">
                        <a class="router-link" href="<?php echo e(shop_product_url($product)); ?>">
                            <img class="<?php echo e($product['status']==-1 ? 'stop-production-img' : ''); ?>" src="<?php echo e(url('files/thumbnails/'.$product['image_url'])); ?>">
                        </a>
                    </div>

                    <?php if(isset($category)): ?>
                        <?php if ($__env->exists('productComparison::product-list-check-box')) echo $__env->make('productComparison::product-list-check-box', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>

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

                                        <?php
                                        $d=getDiscountValue($product->firstProductPrice['price1'],$product->firstProductPrice['price2']);
                                        ?>
                                        <div class="discount-badge">
                                            <?php echo e('٪'.replace_number($d)); ?>

                                        </div>

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

                    <?php echo $__env->make('position_view',['name'=>'end_search_product_box'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(sizeof($result['product'])===0): ?>
                    <div class="not_fount_product_message">
                        محصولی برای نمایش یافت نشد
                    </div>
            <?php endif; ?>


            <div class="product-list-paginate">
                <?php
                      $links=$result['product']->links();
                      $links=str_replace('router-link','search-product',$links);
                ?>
                <?php echo $links; ?>

            </div>

        </template>

    </desktop-filter-list>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('front-theme::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/themes/theme1/views/cat_product.blade.php ENDPATH**/ ?>