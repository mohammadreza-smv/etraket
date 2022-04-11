<?php $__env->startSection('content'); ?>

    <div class="content">

        <page-content>
              <h2><?php echo e($page->title); ?></h2>

              <div>
                  <?php echo strip_tags($page->content,'<p><br><img>'); ?>

              </div>

        </page-content>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('seo'); ?>
<meta name="description" content="<?php echo e($page->description); ?>"/>
    <meta name="keywords" content="<?php echo e($page->keywords); ?>"/>
    <meta property="og:site_name" content="<?php echo e(config('shop-info.shop_name')); ?>"/>
    <meta property="og:description" content="<?php echo e($page->description); ?>"/>
    <meta property="og:title" content="<?php echo e($page->title); ?>"/>
    <meta property="og:locale" content="fa_IR"/>
    <meta name="twitter:description" content="<?php echo e($page->description); ?>"/>
    <meta name="twitter:title" content="<?php echo e($page->title); ?>"/>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/pages/resource/views/page.blade.php ENDPATH**/ ?>