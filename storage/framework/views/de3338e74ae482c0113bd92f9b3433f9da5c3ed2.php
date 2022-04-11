<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app_url" content="<?php echo e(url(('/'))); ?>">
    <title><?php echo e(config('shop-info.shop_name')); ?></title>
    <?php echo e(add_css_file('desktop')); ?>

    <?php echo $__env->yieldContent('seo'); ?>
    <link href="<?php echo e(asset('themes/theme1/mobile.css?id=ussssej')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('themes/theme1/main.css?id=psjk')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/widgets.css?id='.config('cms.widgetId'))); ?>" rel="stylesheet">
    <meta name="theme-color" content="#B3E5FC" />
</head>
<body>

<div id="app">



    <v-app class="app-style">

          <?php if ($__env->exists('front-theme::include.mobile-app-bar')) echo $__env->make('front-theme::include.mobile-app-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

          <mobile-progress-box ref="progress_box"></mobile-progress-box>

          <v-main>
              <app-content>
                  <?php echo $__env->yieldContent('content'); ?>
              </app-content>

              <?php echo $__env->make('position_view',['name'=>'mobile_layout','type'=>'content'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          </v-main>


















        <div>
            <?php if ($__env->exists('themes::widgets.view',['location'=>'mobile_layout_footer'])) echo $__env->make('themes::widgets.view',['location'=>'mobile_layout_footer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </v-app>



</div>


<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
<?php /**PATH /home/teraketc/AppCode/themes/theme1/layouts/mobile-app.blade.php ENDPATH**/ ?>