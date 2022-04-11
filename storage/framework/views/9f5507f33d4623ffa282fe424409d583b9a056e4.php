<?php if(array_key_exists($args['tag'],$tags)): ?>

   <?php if(array_key_exists($args['id'],$tags[$args['tag']])): ?>

       <?php if(array_key_exists('view',$tags[$args['tag']][$args['id']])): ?>

           <?php if ($__env->exists($tags[$args['tag']][$args['id']]['view'])) echo $__env->make($tags[$args['tag']][$args['id']]['view'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
       <?php endif; ?>

   <?php endif; ?>

<?php endif; ?>
<?php /**PATH /home2/teraketc/AppCode/modules/themes/resource/views/widgets/widget-view.blade.php ENDPATH**/ ?>