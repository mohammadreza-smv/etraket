<?php
    $view=run_action($name,[],true);
?>

<?php if(sizeof($view)>0): ?>
    <?php echo $__env->make($view[0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>

    <?php if(isset($component) && $component=='yes'): ?>
        <?php echo '<'.$path.'  :item="slotProps.item"></'.$path.'>'; ?>
    <?php else: ?>
        <?php if ($__env->exists($path)) echo $__env->make($path, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>


<?php endif; ?>



<?php /**PATH /home2/teraketc/AppCode/resources/views/CompleteView.blade.php ENDPATH**/ ?>