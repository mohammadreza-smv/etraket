<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
              ['title'=>'مدیریت فروشندگان','url'=>url('admin/sellers/list')],
              ['title'=>'مدیریت کمیسیون ها','url'=>url('admin/sellers/commissions')]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <?php
             $args['title']='مدیریت کمیسیون ها';
             $args['route']='admin/sellers/commissions';
             $args['trashCount']=$trash_commission_count;
             $args['routeParam']='کمیسیون';
        ?>

        <?php if ($__env->exists('sellers::commissions._search_form')) echo $__env->make('sellers::commissions._search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php

            \App\Lib\GridView::showTable([
                'dataProvider'=>$commissions,
                'columns'=>[
                    ['label'=>'دسته','attr'=>function($value){
                         if($value->category!==null){
                             return e($value->category->name);
                         }
                    }],
                    ['label'=>'برند','attr'=>function($value){
                        if($value->brand!==null){
                            return e($value->brand->brand_name);
                        }
                    }],
                    ['label'=>'درصد کمیسیون','attr'=>function($value){
                        return '٪'.e(replace_number($value->percentage));
                    }]
                ],
                'route_param'=>'sellers/commissions',
                'tableLabel'=>'کمیسیون'
            ]);
            ?>

            <?php echo e($commissions->links()); ?>

         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/commissions/index.blade.php ENDPATH**/ ?>