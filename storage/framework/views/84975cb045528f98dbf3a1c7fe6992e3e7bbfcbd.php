<?php
$key=$args['id'];
?>
<?php if(array_key_exists('slide',$tags)): ?>

    <?php if(array_key_exists($key,$tags['slide'])): ?>


        <?php
           $items=$tags['slide'][$key]['items'];

        ?>

        <div  id="<?php echo e($key); ?>" >
            <theme-carousel>

                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <v-carousel-item
                        key="<?php echo e($key); ?>"
                    >
                        <a href="<?php echo e($item['link']); ?>" class="router-link">
                            <img style="background-image:url('<?php echo e($item['src']); ?>')"/>
                        </a>

                    </v-carousel-item>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </theme-carousel>
        </div>

    <?php endif; ?>

<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/themes/resource/views/widgets/slide.blade.php ENDPATH**/ ?>