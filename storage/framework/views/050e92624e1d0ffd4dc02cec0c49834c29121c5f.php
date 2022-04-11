<?php
    $key=$args['id'];
?>
<?php if(array_key_exists('img',$tags)): ?>

    <?php if(array_key_exists($key,$tags['img'])): ?>

        <?php
           $src=$tags['img'][$key]['src'];
           $link=$tags['img'][$key]['link'];
           $hoverSrc=array_key_exists('hoverSrc',$tags['img'][$key]) ? $tags['img'][$key]['hoverSrc'] : '';
        ?>
        <a <?php if(!empty($link)): ?> href="<?php echo e($link); ?>" <?php endif; ?> target="_blank">
            <img id="<?php echo e($key); ?>" src="<?php echo e($src); ?>" />
            <?php if(!empty($hoverSrc)): ?>
                <hover-image
                    src="<?php echo e($hoverSrc); ?>"
                    id="<?php echo e($key); ?>"
                ></hover-image>
            <?php endif; ?>
        </a>

    <?php endif; ?>

<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/themes/resource/views/widgets/img.blade.php ENDPATH**/ ?>