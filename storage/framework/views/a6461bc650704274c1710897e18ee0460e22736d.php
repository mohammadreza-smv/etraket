<?php $__env->startSection('panel-content'); ?>

    <?php
         $panelMenu=array();
         $panelMenu[0]=['label'=>'اطلاعات شخصی','url'=>'user/profile/additional-info'];
         $panelMenu=CompleteData('user_panel_menu',$panelMenu);
         $args=['title'=>''];
    ?>

    <?php if (isset($component)) { $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\UserPanelBox::class, ['args' => $args]); ?>
<?php $component->withName('user-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>


        <div class="profile_item_list" style="margin:20px 8px">
            <?php $__currentLoopData = $panelMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(url($value['url'])); ?>" class="router-link">
                    <div class="profile_item_header">
                        <span><?php echo e($value['label']); ?></span>
                        <v-icon>mdi-chevron-left</v-icon>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <form method="post" action="<?php echo e(url('logout')); ?>" id="logout_form"><?php echo csrf_field(); ?></form>

            <div class="profile_item_header" style="border: 0px" onclick="vm.$root.$emit('send_post_request','<?php echo e(url('logout')); ?>',{})">
                <div>
                    <v-icon>mdi-logout</v-icon>
                    <span>خروج</span>
                </div>
            </div>

        </div>


     <?php if (isset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950)): ?>
<?php $component = $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950; ?>
<?php unset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.mobile.user-panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/users/resource/views/user-panel/mobile/profile.blade.php ENDPATH**/ ?>