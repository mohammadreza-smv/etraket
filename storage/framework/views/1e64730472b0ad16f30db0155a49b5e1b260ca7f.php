<?php $__env->startSection('content'); ?>

    <div>
        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت پست ها','url'=>url('admin/blog/posts')],
            ['title'=>'ویرایش پست','url'=>url('admin/blog/posts/'.$post->id.'/edit')]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="panel">

            <div class="header">
                ویرایش پست - <?php echo e($post->title); ?>

            </div>

            <?php echo $__env->make('blog::post._form',['type'=>'edit'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/blog/resource/views/post/edit.blade.php ENDPATH**/ ?>