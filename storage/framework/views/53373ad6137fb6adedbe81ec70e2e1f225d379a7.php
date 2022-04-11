<?php $__env->startSection('panel-content'); ?>

    <?php $args=['title'=>'لیست علاقه مندی ها'] ?>

    <?php if (isset($component)) { $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\UserPanelBox::class, ['args' => $args]); ?>
<?php $component->withName('user-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

        <?php
            $shop_product_url=shop_product_url_theme();
        ?>
        <mobile-favorite-list
            shop_product_url="<?php echo e($shop_product_url); ?>"
        >
            <template v-slot:loading_box>
                <a href="<?php echo e(url('')); ?>">
                    <img  src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="favorite-loading-logo">
                </a>
            </template>
        </mobile-favorite-list>
     <?php if (isset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950)): ?>
<?php $component = $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950; ?>
<?php unset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.mobile.user-panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/favourite/resource/views/mobile/favorite.blade.php ENDPATH**/ ?>