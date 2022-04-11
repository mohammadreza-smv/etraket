<?php $__env->startSection('content'); ?>

    <div>
        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت نظرات','url'=>url('admin/comments')]]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
              $args=[];
              $args['title']='نظرات کاربران';
              $args['route']='admin/comments';
              $args['trashCount']=$trash_comment_count;
              $args['routeParam']='نظر';
              $args['remove_new_record']=true;
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

             <panel-comment-list
                 :comments="<?php echo e(json_encode($comments)); ?>"
                 :removed="true"
             ></panel-comment-list>

            <?php echo e($comments->links()); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/comments/resource/views/panel/index.blade.php ENDPATH**/ ?>