<?php
   $key=$args['id'];
?>
<?php if(array_key_exists('p',$tags)): ?>

    <?php if(array_key_exists($key,$tags['p'])): ?>

        <?php
            $content=$tags['p'][$key]['content'];
            $showMore=array_key_exists('showMore',$tags['p'][$key]) ? $tags['p'][$key]['showMore'] : false
        ?>

        <div id="<?php echo e($key); ?>" >
            <?php if($showMore): ?> <more-content-box el_id="<?php echo e($key); ?>"> <?php endif; ?>
               <?php echo $content; ?>

           <?php if($showMore): ?> </more-content-box> <?php endif; ?>
        </div>
    <?php endif; ?>

<?php endif; ?>

<?php /**PATH /home2/teraketc/AppCode/modules/themes/resource/views/widgets/p.blade.php ENDPATH**/ ?>