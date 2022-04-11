<?php $__env->startSection('content'); ?>

    <div>
        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت گارانتی ها','url'=>url('admin/warranties')]]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('warranty::_search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']='مدیریت گارانتی ها';
            $args['route']='admin/warranties';
            $args['trashCount']=$trash_warranty_count;
            $args['routeParam']='گارانتی';
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$warranty,
                'columns'=>[
                    ['label'=>'نام گارانتی','attr'=>'name']
                ],
                'route_param'=>'warranties',
                'tableLabel'=>'گارانتی'
            ]);
            ?>

            <?php echo e($warranty->links()); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/warranty/resource/views/index.blade.php ENDPATH**/ ?>