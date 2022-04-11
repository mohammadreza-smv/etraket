<panel-box <?php if(array_key_exists('progress-param',$args)): ?> progress_param="<?php echo e($args['progress-param']); ?>" <?php endif; ?>>
    <div>
        <?php if(array_key_exists('title',$args)): ?>
            <div class="header">
                <?php echo e($args['title']); ?>


                <?php if(array_key_exists('trashCount',$args) && $args['trashCount']!==null): ?>
                    <?php echo $__env->make('backend-theme::item_table',
                       [
                           'count'=>$args['trashCount'],
                           'route'=>$args['route'],
                           'title'=>$args['routeParam'],
                           'other'=>array_key_exists('items',$args) ? $args['items'] : [],
                           'remove_new_record'=>array_key_exists('remove_new_record',$args) ? true : false,
                           'queryString'=>array_key_exists('queryString',$args) ? $args['queryString'] : null
                       ]
                , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
        <?php else: ?>

            <div class="header">

                <?php echo e($header); ?>


            </div>

        <?php endif; ?>

        <div class="panel_content">
            <?php echo e($slot); ?>

        </div>

    </div>
</panel-box>
<?php /**PATH /home/teraketc/AppCode/themes/AdminPanel/panel-box.blade.php ENDPATH**/ ?>