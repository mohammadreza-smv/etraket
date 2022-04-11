<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
             ['title'=>'گالری تصاویر','url'=>url('sellers/panel/products/gallery/'.$product->id)]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=['title'=>'  گالری تصاویر - '.$product->title];
        ?>

        <?php if (isset($component)) { $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde = $component; } ?>
<?php $component = $__env->getContainer()->make(Modules\sellers\components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('seller-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <upload-box
                product_id="<?php echo e($product->id); ?>"
                :product_gallery="<?php echo e($product_gallery); ?>"
                url_param="sellers/panel"
            >

            </upload-box>

         <?php if (isset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde)): ?>
<?php $component = $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde; ?>
<?php unset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/panel/products/gallery.blade.php ENDPATH**/ ?>