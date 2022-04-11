<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app_url" content="<?php echo e(url(('/'))); ?>">
    <title>فروشگاه <?php echo e(config('shop-info.shop_name')); ?></title>
    <?php echo e(add_css_file('')); ?>

    <link href="<?php echo e(url('modules/users/style.css?id=dsgsjj')); ?>" rel="stylesheet">
</head>
<body>

<div id="app">

    <v-app>
        <app-content>
            <?php echo $__env->yieldContent('content'); ?>
        </app-content>
    </v-app>



</div>

<?php registerVueFile('') ?>

</body>
</html>
<?php /**PATH /home2/teraketc/AppCode/modules/users/resource/views/auth/layouts/mobile.blade.php ENDPATH**/ ?>