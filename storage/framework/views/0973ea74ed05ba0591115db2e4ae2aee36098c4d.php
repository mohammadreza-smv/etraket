<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('sellers::panel.breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
            ['title'=>'ثبت مشخصات فنی محصول','url'=>url('sellers/panel/products/'.$product->id.'/items')]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
        $args=[];
        $args['title']=' افزودن مشخصات فنی - '.e($product->title);
        ?>


        <?php if (isset($component)) { $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde = $component; } ?>
<?php $component = $__env->getContainer()->make(Modules\sellers\components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('seller-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <add-product-items
                :product_items="<?php echo e(json_encode($product_items)); ?>"
                product_id="<?php echo e($product->id); ?>"
                route_param="sellers/panel"
            >
                <template v-slot:after_input="slotProps">
                    <?php echo $__env->make('CompleteView',[
                        'path'=>'add-item-input',
                        'name'=>'add_value_input_tag',
                        'component'=>'yes'
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </template>
            </add-product-items>
         <?php if (isset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde)): ?>
<?php $component = $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde; ?>
<?php unset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/panel/products/items.blade.php ENDPATH**/ ?>