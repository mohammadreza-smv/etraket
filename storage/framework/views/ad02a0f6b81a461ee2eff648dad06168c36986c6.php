<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت اسلایدر ها','url'=>url('admin/sliders')]]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']='مدیریت اسلایدر ها';
            $args['route']='admin/sliders';
            $args['trashCount']=$trash_slider_count;
            $args['routeParam']='اسلایدر';
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php

            \App\Lib\GridView::showTable([
                'dataProvider'=>$sliders,
                'columns'=>[
                    ['label'=>'عنوان','attr'=>'title'],
                    ['label'=>'تصویر','attr'=>function($model){
                        $src=url('files/slider/'.$model->image_url);
                        return '<img src="'.$src.'" class="slide_image" style="margin:10px 0px">';
                    },'html'=>true]
                ],
                'route_param'=>'sliders',
                'tableLabel'=>'اسلایدر'
            ]);

            ?>
            <?php echo e($sliders->links()); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/sliders/resource/views/panel/index.blade.php ENDPATH**/ ?>