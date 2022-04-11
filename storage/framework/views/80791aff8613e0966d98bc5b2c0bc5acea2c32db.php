<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','url'=>url('admin/products')],
            ['title'=>'ثبت مشخصات فنی محصول','url'=>url('admin/products/'.$product->id.'/items')]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']=' افزودن مشخصات فنی - '.e($product->title);
        ?>


        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <add-product-items
                :product_items="<?php echo e(json_encode($product_items)); ?>"
                product_id="<?php echo e($product->id); ?>"
                route_param="admin"
            >
                <template v-slot:after_input="slotProps">
                    <?php echo $__env->make('CompleteView',[
                        'path'=>'add-item-input',
                        'name'=>'add_value_input_tag',
                        'component'=>'yes'
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </template>
            </add-product-items>
         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/items/resource/views/panel/items.blade.php ENDPATH**/ ?>