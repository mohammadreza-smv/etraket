<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app_url" content="<?php echo e(url(('/'))); ?>">
    <title>پنل مدیریت</title>
    <?php echo e(add_css_file('desktop')); ?>

    <link href="<?php echo e(asset('themes/AdminPanel/style.css?id=v1')); ?>" rel="stylesheet" />
    <?php echo $__env->yieldContent('head'); ?>

</head>
<body>

<div id="app">

    <v-app class="app-style">

        <?php
           $sideBarMenu=Config::get('app.panel_menu');
           $access=isset($access) ? json_decode($access,true) : null;
           $sideBarMenu=getAccessMenu($sideBarMenu,$access);
           ksort($sideBarMenu);
        ?>
        <drawer :items="<?php echo e(json_encode($sideBarMenu)); ?>"></drawer>
        <v-main>
            <panel-app-bar></panel-app-bar>
            <div class="panel-content">
                <app-content >
                    <?php echo $__env->yieldContent('content'); ?>
                </app-content>
            </div>
            <response-dialog></response-dialog>
            <layout-progress>
                <template v-slot:loading_box>
                    <a href="<?php echo e(url('')); ?>">
                        <img  src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>">
                    </a>
                </template>
            </layout-progress>
        </v-main>
    </v-app>

</div>

<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
<?php /**PATH /home2/teraketc/AppCode/themes/AdminPanel/layout.blade.php ENDPATH**/ ?>