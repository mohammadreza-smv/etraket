<?php
$key=$args['id'];
?>
<?php if(array_key_exists('img',$tags)): ?>

    <?php if(array_key_exists($key,$tags['ul'])): ?>

        <?php
            $items=$tags['ul'][$key]['items'];
            $title=$tags['ul'][$key]['title'];
        ?>


        <theme-ul
            id="<?php echo e($key); ?>"
            tag_id="<?php echo e($key); ?>"
         >
            <span class="ul-title">
                <?php echo e($title); ?>

            </span>

            <ul>

                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!empty($item['title'] )): ?>
                        <li>
                            <a <?php if(!empty($item['link'])): ?> href="<?php echo e($item['link']); ?>" <?php endif; ?>>
                                <?php echo e($item['title']); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

        </theme-ul>

    <?php endif; ?>

<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/themes/resource/views/widgets/ul.blade.php ENDPATH**/ ?>