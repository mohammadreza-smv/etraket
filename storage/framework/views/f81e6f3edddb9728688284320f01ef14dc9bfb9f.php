<?php $__env->startSection('content'); ?>


    <div class="page-content">

        <ul class="list-inline map_ul" style="margin-bottom:5px !important">
            <li>
                <a class="router-link" href="<?php echo e(url('/')); ?>">فروشگاه</a>
                /
            </li>
            <?php if($category && $category->getParent->getParent->name!='-'): ?>
                <li>
                    <a class="router-link" href="<?php echo e(url('main/'.$category->getParent->getParent->url)); ?>">
                        <?php echo e($category->getParent->getParent->name); ?>

                    </a>
                    /
                </li>
            <?php endif; ?>
            <?php if($category &&  $category->getParent->name!='-'): ?>
                <li>
                    <a class="router-link" href="<?php echo e(url('search/'.$category->getParent->url)); ?>">
                        <?php echo e($category->getParent->name); ?>

                    </a>
                    /
                </li>
            <?php endif; ?>
            <?php if($category): ?>
                <li>
                    <a class="router-link" href="<?php echo e(url('search/'.$category->url)); ?>">
                        <?php echo e($category->name); ?>

                    </a>
                    /
                </li>
            <?php endif; ?>
            <li>
                <a href="<?php echo e(url()->current()); ?>" class="router-link">
                    <?php echo e($product->title); ?>

                </a>
            </li>
        </ul>
        <div class="content">

            <div class="product_info">

                <div class="product_image_box">
                    <offer-time></offer-time>
                    <div>
                        <ul class="product_options">

                            <li>
                                <?php if ($__env->exists('favourite::short-code')) echo $__env->make('favourite::short-code', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </li>

                            <li>
                                <desktop-share-box product_id='<?php echo e($product->id); ?>'
                                                   product_url="<?php echo e(shop_product_url($product)); ?>"
                                                   short_product_url="<?php echo e(shop_short_product_url($product)); ?>"
                                >
                                </desktop-share-box>
                            </li>

                            <li>
                               <?php if ($__env->exists('productComparison::product-page-link')) echo $__env->make('productComparison::product-page-link', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </li>

                            <li>
                                <vue-chart :product_id="<?php echo e($product->id); ?>"></vue-chart>
                            </li>
                        </ul>

                        <div class="default_product_pic">
                            <?php if(!empty($product->image_url)): ?>
                                <img class="default_pic" src="<?php echo e(url('files/products/'.$product->image_url)); ?>" data-zoom-img="<?php echo e(url('files/products/'.$product->image_url)); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="product_gallery_box">
                            <?php echo $__env->make('include.Gallery', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>



                    </div>
                </div>
                <div class="product_data">

                    <div id="zoom_box"></div>
                    <div class="product_headline">
                        <h6 class="product_title">
                            <?php echo e($product->title); ?>

                            <?php if(!empty($product->ename) && $product->ename!='null'): ?> <span><?php echo e($product->ename); ?></span> <?php endif; ?>
                        </h6>
                    </div>
                    <div>
                        <ul class="list-inline product_data_ul">
                            <?php if($product->getBrand->brand_ename): ?>
                                <li>
                                    <span>برند : </span>
                                    <a href="<?php echo e(url('brand/'.$product->getBrand->brand_ename)); ?>" class="data_link">
                                        <span><?php echo e($product->getBrand->brand_name); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <span>دسته بندی : </span>
                                <a href="<?php echo e(url('search/'.$category->url)); ?>" class="data_link">
                                    <span><?php echo e($category->name); ?></span>
                                </a>
                            </li>
                        </ul>
                        <div class="row">

                            <div class="col-7">

                                <?php if($product->status==1): ?>
                                    <?php if ($__env->exists('priceVariation::product.params')) echo $__env->make('priceVariation::product.params', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endif; ?>

                                <important-item></important-item>

                                <?php if($product->fake==1): ?>
                                    <p class="fake_tag">
                                        <v-icon color="red">mdi-alert</v-icon>
                                        <span>این محصول توسط تولید کننده اصلی (برند) تولید نشده است</span>
                                    </p>
                                <?php endif; ?>

                            </div>
                            <div class="col-5">
                                <?php if($product->status==1): ?>
                                    <div id="variation_box">
                                        <?php if ($__env->exists('priceVariation::product.detail')) echo $__env->make('priceVariation::product.detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                <?php else: ?>
                                    <div class="product-unavailable">
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
                                                <?php echo $__env->make('position_view',['name'=>'product_not_available',
                                               'type'=>'content'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($product->status==1): ?>
               <?php if ($__env->exists('priceVariation::product.list')) echo $__env->make('priceVariation::product.list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if ($__env->exists('themes::widgets.view',['location'=>'desktop_show_product'])) echo $__env->make('themes::widgets.view',['location'=>'desktop_show_product'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div id="tab_div">
                <?php echo $__env->make('front-theme::include.product_page_tabs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>


            <desktop-gallery :images="<?php echo e(json_encode($product->Gallery)); ?>"></desktop-gallery>

        </div>
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


<?php echo $__env->make('front-theme::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/themes/theme1/views/show_product.blade.php ENDPATH**/ ?>