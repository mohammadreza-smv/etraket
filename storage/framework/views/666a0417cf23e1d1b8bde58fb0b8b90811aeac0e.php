<?php $__env->startSection('content'); ?>

    <?php if ($__env->exists('themes::widgets.view',['location'=>'desktop_home_content'])) echo $__env->make('themes::widgets.view',['location'=>'desktop_home_content'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('seo'); ?>
    <meta name="description" content="<?php echo e(config('shop-info.description')); ?>"/>
    <meta name="keywords" content="<?php echo e(config('shop-info.keywords')); ?>"/>
    <meta property="og:site_name" content="<?php echo e(config('shop-info.shop_name')); ?>"/>
    <meta property="og:description" content="<?php echo e(config('shop-info.description')); ?>"/>
    <meta property="og:title" content="<?php echo e(config('shop-info.shop_name')); ?>"/>
    <meta property="og:locale" content="fa_IR"/>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('front-theme::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/themes/theme1/views/index.blade.php ENDPATH**/ ?>