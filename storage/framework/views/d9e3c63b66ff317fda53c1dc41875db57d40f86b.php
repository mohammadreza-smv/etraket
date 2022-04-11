<?php
    $key=$args['id'];
?>
<?php if(array_key_exists('code',$tags)): ?>

    <?php if(array_key_exists($key,$tags['code'])): ?>

        <?php
            $content=$tags['code'][$key]['content'];
        ?>

        <div id="<?php echo e($key); ?>" >
            <?php echo $content; ?>

        </div>

    <?php endif; ?>

<?php endif; ?>

<?php /**PATH /home2/teraketc/AppCode/modules/themes/resource/views/widgets/code.blade.php ENDPATH**/ ?>