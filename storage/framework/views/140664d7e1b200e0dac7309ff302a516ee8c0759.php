<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app_url" content="<?php echo e(url(('/'))); ?>">
    <title>فروشگاه <?php echo e(config('shop-info.shop_name')); ?></title>
    <?php echo $__env->yieldContent('head'); ?>
    <?php echo e(add_css_file('desktop')); ?>

    <link href="<?php echo e(asset('modules/cart/style.css')); ?>" rel="stylesheet">
</head>
<body>

<div id="app">

    <v-app>

        <request-progress>
            <template v-slot:loading_box>
                <a href="<?php echo e(url('')); ?>">
                    <img  src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="loading-logo">
                </a>
            </template>
        </request-progress>

        <app-content>
            <?php echo $__env->yieldContent('content'); ?>
        </app-content>
    </v-app>

</div>



<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
<?php /**PATH /home2/teraketc/AppCode/modules/cart/resource/views/layouts/order.blade.php ENDPATH**/ ?>