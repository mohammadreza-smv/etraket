<?php
$key=$args['id'];
?>

<?php if(array_key_exists('card',$tags)): ?>

    <?php if(array_key_exists($key,$tags['card'])): ?>

        <?php
            $title=$tags['card'][$key]['title'];
            $content=$tags['card'][$key]['content'];
        ?>

        <a <?php if(!empty($link)): ?> href="<?php echo e($link); ?>" <?php endif; ?> target="_blank">
            <theme-card
                id="<?php echo e($key); ?>"
                tag_id="<?php echo e($key); ?>"
            >
                <template v-slot:title>
                    <?php echo e($title); ?>

                </template>

                <template v-slot:content>
                    <?php echo e($content); ?>

                </template>
            </theme-card>

        </a>

    <?php endif; ?>

<?php endif; ?>
<?php /**PATH /home2/teraketc/AppCode/modules/themes/resource/views/widgets/card.blade.php ENDPATH**/ ?>