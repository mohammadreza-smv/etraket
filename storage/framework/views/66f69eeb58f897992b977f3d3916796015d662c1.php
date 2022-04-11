<?php $__env->startSection('content'); ?>

    <div>
        <?php if ($__env->exists('themes::widgets.view',['location'=>'blog_index'])) echo $__env->make('themes::widgets.view',['location'=>'blog_index'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('blog::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/blog/resource/views/index.blade.php ENDPATH**/ ?>