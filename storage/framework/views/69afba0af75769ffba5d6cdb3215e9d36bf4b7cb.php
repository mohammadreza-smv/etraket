<?php $__env->startSection('panel-content'); ?>

    <?php $args=['title'=>'آدرس های من']; ?>

    <?php if (isset($component)) { $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\UserPanelBox::class, ['args' => $args]); ?>
<?php $component->withName('user-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

        <div style="width:100%">

            <div class="profile_address">
                <profile-address>

                    <template v-slot:loading_box>
                        <a href="<?php echo e(url('')); ?>">
                            <img  src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="loading-logo">
                        </a>
                    </template>

                </profile-address>
            </div>

        </div>

     <?php if (isset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950)): ?>
<?php $component = $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950; ?>
<?php unset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('front-theme::layouts.user-panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/address/resource/views/userPanel/address.blade.php ENDPATH**/ ?>