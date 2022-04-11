<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
               ['title'=>'مدیریت رنگ ها','url'=>url('admin/colors')]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('colors::_search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']='مدیریت رنگ ها';
            $args['route']='admin/colors';
            $args['trashCount']=$trash_color_count;
            $args['routeParam']='رنگ';
        ?>
        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$color,
                'columns'=>[
                    ['label'=>'نام رنگ','attr'=>'name'],
                    ['label'=>'کد رنگ','attr'=>function($model){
                        $colorCode=$model->code;
                        $style=$model->name=='سفید' ? ' color:#000' :'';
                        return '<span class="color-code" style="background:#'.$colorCode.';'.$style.'" >'.$model->code
                            .'</span>';
                    },'html'=>true]
                ],
                'route_param'=>'colors',
                'tableLabel'=>'رنگ'
            ]);
            ?>

            <?php echo e($color->links()); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/colors/resource/views/index.blade.php ENDPATH**/ ?>