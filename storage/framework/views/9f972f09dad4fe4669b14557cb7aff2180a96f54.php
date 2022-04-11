<?php if(isset($name)): ?>
    <?php $position_views=position_view($name) ?>

    <?php $__currentLoopData = $position_views; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $view): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $a=isset($args) ? $args : [] ?>
        <?php if ($__env->exists($view['view'],$a)) echo $__env->make($view['view'],$a, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /home2/teraketc/AppCode/resources/views/position_view.blade.php ENDPATH**/ ?>