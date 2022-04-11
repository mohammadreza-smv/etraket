<?php $__env->startSection('content'); ?>
    <comment-form :product="<?php echo e(json_encode($product)); ?>"></comment-form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/comments/resource/views/comment_form.blade.php ENDPATH**/ ?>