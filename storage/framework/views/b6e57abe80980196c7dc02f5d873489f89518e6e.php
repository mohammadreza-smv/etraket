<?php $__env->startSection('panel-content'); ?>

    <?php $args=['title'=>'تاریخچه سفارشات']; ?>

    <?php if (isset($component)) { $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\UserPanelBox::class, ['args' => $args]); ?>
<?php $component->withName('user-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

        <div class="order-category-tab">

            <?php
                $shop_product_url=shop_product_url_theme();
                $orderTypes=[];
                $types=user_panel_submission_types();
                foreach ($types as $key=>$type){
                    $count=${$key};
                    $orderTypes[$key]=['count'=>$count,'title'=>$type['title']];
                }
            ?>
            <user-panel-order-list
                :orders="<?php echo e(json_encode($orders)); ?>"
                shop_product_url="<?php echo e($shop_product_url); ?>"
                delivered="<?php echo e($delivered); ?>"
                :order_types="<?php echo e(json_encode($orderTypes)); ?>"
            >

            </user-panel-order-list>

        </div>

     <?php if (isset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950)): ?>
<?php $component = $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950; ?>
<?php unset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.user-panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/orders/resource/views/userpanel//list.blade.php ENDPATH**/ ?>