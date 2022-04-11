<?php $__env->startSection('head'); ?>
    <link href="<?php echo e(url('css/swiper.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div style="position: relative;padding-bottom: 50px">


        <div class="product_item_box margin">
            <div class="product_headline">
                <offer-time></offer-time>
                <h6 class="product_title">
                    <?php echo e($product->title); ?>

                    <?php if(!empty($product->ename) && $product->ename!='null'): ?> <span><?php echo e($product->ename); ?></span> <?php endif; ?>
                </h6>
            </div>
            <div class="product_options">
                <div>
                    <?php if ($__env->exists('favourite::short-code')) echo $__env->make('favourite::short-code', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <span class="fa fa-share-alt"></span>
                    <span class="fa fa-line-chart"></span>
                </div>
                <div style="display: flex;align-items: center">
                    <?php
                    $width=0;
                    if($product->score_count>0)
                    {
                        $width=$product->score/($product->score_count*6);
                    }
                    $width=$width*20;
                    ?>
                    <span><?php echo e(replace_number($product->score_count)); ?> نفر</span>
                    <div class="score">
                        <div class="gray">
                            <div class="red" style="width: <?php echo e($width); ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <?php if($product->Gallery!=null && sizeof($product->Gallery)>0): ?>
                    <?php if ($__env->exists('gallery::carousels')) echo $__env->make('gallery::carousels', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php else: ?>
                    <img src="<?php echo e(url('files/products/'.$product->image_url)); ?>" class="product_image">
                <?php endif; ?>

            </div>

            <div class="row">
                <ul class="list-inline product_data_ul">
                    <?php if($product->getBrand->brand_ename): ?>
                        <li>
                            <span>برند : </span>
                            <a href="<?php echo e(url('brand/'.$product->getBrand->brand_ename)); ?>" class="router-link data_link">
                                <span><?php echo e($product->getBrand->brand_name); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <span>دسته بندی : </span>
                        <a href="<?php echo e(url('search/'.$category->url)); ?>" class="router-link data_link">
                            <span><?php echo e($category->name); ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="product_item_box">
            <div style="padding: 20px">
                <?php if($product->status==1): ?>
                    <div>

                        <?php if ($__env->exists('priceVariation::product.params')) echo $__env->make('priceVariation::product.params', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php if ($__env->exists('priceVariation::product.detail')) echo $__env->make('priceVariation::product.detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php if($product->fake==1): ?>
                            <p class="fake_tag">
                                <v-icon color="red">mdi-alert</v-icon>
                                <span>این محصول توسط تولید کننده اصلی (برند) تولید نشده است</span>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="product_unavailable">
                       <span>
                           <?php if($product->status==-1): ?>
                               توقف تولید
                           <?php else: ?>
                               ناموجود
                           <?php endif; ?>
                        </span>
                        <p>
                            <?php if($product->status==-1): ?>
                                متاسفانه تولید و فروش این کالا متوقف شده است. می‌توانید از طریق لیست بالای صفحه، از محصولات مشابه این کالا دیدن نمایید.
                            <?php else: ?>
                                متاسفانه این کالا در حال حاضر موجود نیست. می‌توانید از طریق لیست بالای صفحه، از محصولات مشابه این کالا دیدن نمایید
                                متاسفانه این کالا در حال حاضر موجود نیست. می‌توانید از طریق لیست بالای صفحه، از محصولات مشابه این کالا دیدن نمایید

                                <?php echo $__env->make('position_view',['name'=>'product_not_available',
                               'type'=>'content'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <?php endif; ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="product_item_box">
            <important-item theme="mobile"></important-item>
        </div>


        <?php if($product->status==1): ?>
           <?php if ($__env->exists('priceVariation::product.mobile-list')) echo $__env->make('priceVariation::product.mobile-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if ($__env->exists('themes::widgets.view',['location'=>'mobile_show_product'])) echo $__env->make('themes::widgets.view',['location'=>'mobile_show_product'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





        <mobile-vue-chart :product_id="<?php echo e($product->id); ?>"></mobile-vue-chart>

        <mobile-product-items :product_id="<?php echo e($product->id); ?>"></mobile-product-items>

        <?php echo $__env->make('position_view',['name'=>'mobile_product_view','args'=>$product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>





<?php $__env->stopSection(); ?>

<?php $__env->startSection('seo'); ?>
    <meta name="description" content="<?php echo e($product->description); ?>"/>
    <meta name="keywords" content="<?php echo e($product->keywords); ?>"/>
    <meta property="og:site_name" content="<?php echo e(config('shop-info.shop_name')); ?>"/>
    <meta property="og:description" content="<?php echo e($product->description); ?>"/>
    <meta property="og:title" content="<?php echo e($product->title); ?>"/>
    <meta property="og:locale" content="fa_IR"/>
    <meta property="og:image" content="<?php echo e(url('files/products/'.$product->image_url)); ?>"/>
    <meta name="twitter:description" content="<?php echo e($product->description); ?>"/>
    <meta name="twitter:title" content="<?php echo e($product->title); ?>"/>
    <meta name="twitter:image" content="<?php echo e(url('files/products/'.$product->image_url)); ?>"/>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/themes/theme1/views/mobile/show_product.blade.php ENDPATH**/ ?>