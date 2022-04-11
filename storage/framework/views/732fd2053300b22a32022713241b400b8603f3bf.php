<?php $__env->startSection('content'); ?>

    <div>


        <?php echo $__env->make('sellers::panel.breadcrumb',['data'=>[
              ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
              ['title'=>'افزودن محصول جدید','url'=>url('sellers/panel/products/create')],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php $args=['title'=>'افزودن محصول جدید'] ?>


        <?php if (isset($component)) { $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde = $component; } ?>
<?php $component = $__env->getContainer()->make(Modules\sellers\components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('seller-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <?php if ($__env->exists('products::_form',[
                 'type'=>'create',
                 'filters'=>['status'],
                 'url'=>'sellers/panel/products'
            ])) echo $__env->make('products::_form',[
                 'type'=>'create',
                 'filters'=>['status'],
                 'url'=>'sellers/panel/products'
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php if (isset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde)): ?>
<?php $component = $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde; ?>
<?php unset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/panel/products/create.blade.php ENDPATH**/ ?>