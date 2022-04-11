<v-card elevation="1" class="user-panel-box">

    <v-card-title class="profile_menu_title">
        <?php if(array_key_exists('title',$args)): ?>
            <?php echo e($args['title']); ?>


        <?php else: ?>
            <?php echo e($header); ?>

        <?php endif; ?>
    </v-card-title>

    <v-card-text>
        <?php echo e($slot); ?>

    </v-card-text>

</v-card>
<?php /**PATH /home/teraketc/AppCode/themes/theme1/components/user-panel-box.blade.php ENDPATH**/ ?>