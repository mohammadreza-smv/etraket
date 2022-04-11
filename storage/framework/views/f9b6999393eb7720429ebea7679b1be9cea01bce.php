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
    <link rel="stylesheet" href="<?php echo e(asset('modules/blog/style.css?id='.time())); ?>"/>
    <link href="<?php echo e(asset('css/widgets.css?id='.config('cms.widgetId'))); ?>" rel="stylesheet">
</head>
<body>

<div id="app">

    <div id="app-body">
        <v-app class="app-style">

            <?php echo $__env->make('blog::header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <app-content>
                <?php echo $__env->yieldContent('content'); ?>
            </app-content>

        </v-app>
    </div>


</div>



<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
<?php /**PATH /home2/teraketc/AppCode/modules/blog/resource/views/layout.blade.php ENDPATH**/ ?>