<?php $__env->startSection('panel-content'); ?>

    <?php $jdf=new \App\Lib\Jdf();?>

    <div>
        <div class="profile_item_header order_content_header">
            <div>
                <span>آدرس ها</span>
            </div>
        </div>


        <input type="hidden" id="lat" value="0">
        <input type="hidden" id="lng" value="0">
        <div style="margin:10px">
            <profile-address :layout="'mobile'"></profile-address>
        </div>

    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('front-theme::layouts.mobile.user-panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/address/resource/views/mobile/userPanel/address.blade.php ENDPATH**/ ?>