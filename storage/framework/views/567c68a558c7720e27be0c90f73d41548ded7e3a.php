<?php $__env->startSection('content'); ?>

    <div>
        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت نقش های کاربری','url'=>url('admin/userRole')],
             ['title'=>'افزودن نقش کاربری جدید','url'=>url('admin/userRole/create')]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="panel">
            <div class="header">افزودن نقش کاربری جدید</div>

            <?php echo $__env->make('users::roles._form',['type'=>'create'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/users/resource/views/roles/create.blade.php ENDPATH**/ ?>