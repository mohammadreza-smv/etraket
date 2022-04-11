<?php $__env->startSection('content'); ?>

    <div>


        <?php echo $__env->make('sellers::panel.breadcrumb',['data'=>[
              ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
              ['title'=>'مدیریت تنوع های قیمت','url'=>url('sellers/panel/product/price_variation?product_id='.$product->id)],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <?php
            $args=[];
            $args['title']='افزون تنوع قیمت جدید برای '.e($product->title);
        ?>


        <?php if (isset($component)) { $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde = $component; } ?>
<?php $component = $__env->getContainer()->make(Modules\sellers\components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('seller-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <?php if ($__env->exists('priceVariation::panel._form',['type'=>'create','url'=>'sellers/panel/product/price_variation'])) echo $__env->make('priceVariation::panel._form',['type'=>'create','url'=>'sellers/panel/product/price_variation'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php if (isset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde)): ?>
<?php $component = $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde; ?>
<?php unset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/panel/priceVariation/create.blade.php ENDPATH**/ ?>