<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>پنل مدیریت فروشندگان</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app_url" content="<?php echo e(url(('/'))); ?>">
    <link href="<?php echo e(asset('modules/sellers/sellers.css?id=fdfdssgdd')); ?>" rel="stylesheet">
    <?php echo e(add_css_file('desktop')); ?>

</head>
<body>

<div id="app">
    <?php
       $sideBarMenu=getSellerPanelMenu();
    ?>
    <v-app class="app-style">
        <seller-panel-drawer :items="<?php echo e(json_encode($sideBarMenu)); ?>"></seller-panel-drawer>
        <v-main>
            <seller-app-bar></seller-app-bar>
            <div style="padding-top:80px">
                <app-content>
                    <?php echo $__env->yieldContent('content'); ?>
                </app-content>
            </div>
            <response-dialog></response-dialog>
        </v-main>
    </v-app>
</div>

<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
<?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/layouts/panel.blade.php ENDPATH**/ ?>