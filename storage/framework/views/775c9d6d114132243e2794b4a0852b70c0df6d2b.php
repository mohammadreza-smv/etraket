<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت شهر ها','url'=>url('admin/city')],
            ['title'=>'ویرایش شهر','url'=>url('admin/city/'.$city->id.'/edit')]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <?php
            $args=[];
           $args['title']='ویرایش شهر - '.e($city->name);
        ?>


        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <?php echo $__env->make('city::_form',['type'=>'edit'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/city/resource/views/edit.blade.php ENDPATH**/ ?>