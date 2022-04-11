<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
         ['title'=>'مدیریت نقش های کاربری','url'=>url('admin/userRole')],
         ['title'=>'ویرایش نقش کاربری','url'=>url('admin/userRole/'.$userRole->id.'/edit')]
    ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="panel">

            <div class="header">ویرایش نقش کاربری - <?php echo e($userRole->name); ?></div>

            <?php echo $__env->make('users::roles._form',['type'=>'edit'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/users/resource/views/roles/edit.blade.php ENDPATH**/ ?>