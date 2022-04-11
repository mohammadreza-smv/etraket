<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($page_title); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app_url" content="<?php echo e(url(('/'))); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo e(asset('modules/sellers/sellers.css?id=fddf')); ?>" rel="stylesheet">
    <?php echo e(add_css_file('desktop')); ?>

</head>
<body>

<div id="app">
    <v-app class="app-style">
        <app-content>
            <?php echo $__env->yieldContent('content'); ?>
        </app-content>
    </v-app>
</div>

<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
<?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/layouts/auth.blade.php ENDPATH**/ ?>