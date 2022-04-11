<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app_url" content="<?php echo e(url(('/'))); ?>">
    <?php echo $__env->yieldContent('seo'); ?>
    <title><?php echo e(defined('page_title') ? page_title : config('shop-info.shop_name')); ?></title>
    <?php echo e(add_css_file('desktop')); ?>

    <?php echo $__env->yieldContent('head'); ?>
    <link href="<?php echo e(asset('css/shop.css?id=v3')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/widgets.css?id='.config('cms.widgetId'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('themes/theme1/style.css?id=v2')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('themes/theme1/main.css?id=jasddk')); ?>" rel="stylesheet"/>
</head>
<body>

<div id="app">

    <div id="app-body">
        <v-app class="app-style">

            <?php if ($__env->exists('themes::widgets.view',['location'=>'desktop_every_page'])) echo $__env->make('themes::widgets.view',['location'=>'desktop_every_page'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <progress-box ref="progress_box"></progress-box>

            <div class="header">

                <div class="header_row">
                    <a href="<?php echo e(url('')); ?>" class="router-link">
                        <img src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="shop_logo">
                    </a>

                    <header-search></header-search>
                </div>

                <div class="header_action">

                    <div style="margin-top:3px;height:39px">

                        <auth-menu login="<?php echo e(Auth::check() ? 'yes' : 'no'); ?>"
                                   role_id="<?php echo e(Auth::check() ? Auth::user()->role_id : 0); ?>"
                                   role="<?php echo e(Auth::check() ? Auth::user()->role : ''); ?>"
                                   shop_name="<?php echo e(config('shop-info.shop_name')); ?>"
                        >
                            <v-list-item>
                                <v-list-item-icon @click="$root.$emit('send_get_request','<?php echo e(url('user/profile/orders')); ?>')"><v-icon>mdi-basket</v-icon></v-list-item-icon>
                                <v-list-item-title @click="$root.$emit('send_get_request','<?php echo e(url('user/profile/orders')); ?>')"> پیگیری سفارش</v-list-item-title>
                            </v-list-item>

                        </auth-menu>

                    </div>

                    <header-cart cart_type="1"></header-cart>
                </div>

            </div>


            <?php echo $__env->make('front-theme::views.categoryList',['catList'=>$catList], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <app-content>
                <?php echo $__env->yieldContent('content'); ?>
            </app-content>

            <?php echo $__env->make('position_view',['name'=>'desktop_layout','type'=>'content'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <footer>
                <?php if ($__env->exists('themes::widgets.view',['location'=>'desktop_layout_footer'])) echo $__env->make('themes::widgets.view',['location'=>'desktop_layout_footer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </footer>

        </v-app>
    </div>

    <div class="category_cover"></div>

</div>

<div id="default-loading">
    <div class="loading_div">
        <img src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>">
        <div class="spinner">
            <div class="b1"></div>
            <div class="b2"></div>
            <div class="b3"></div>
        </div>
    </div>
</div>

<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
<?php /**PATH /home2/teraketc/AppCode/themes/theme1/layouts/app.blade.php ENDPATH**/ ?>