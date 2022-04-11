<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
           ['title'=>'مدیریت فایل ها','url'=>url('admin/filemanager')]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <file-manager dir="files"></file-manager>

    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/fileManager/resource/views/files.blade.php ENDPATH**/ ?>