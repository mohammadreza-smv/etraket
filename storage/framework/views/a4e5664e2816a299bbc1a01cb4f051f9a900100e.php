<?php $color=$data->model==1 ? 'red' : 'grey'; ?>
<v-tooltip bottom>
    <template v-slot:activator="{ on, attrs }">
        <a class="router-link" href="<?php echo e($url); ?>">
            <v-icon
                color="<?= $color ?>"
                dark
                v-bind="attrs"
                v-on="on"
            >
                mdi-eye-outline
            </v-icon>
        </a>
    </template>
    <span>محتوای پیام</span>
</v-tooltip>
<?php /**PATH /home2/teraketc/AppCode/modules/messages/resource/views/panel/show_icon.blade.php ENDPATH**/ ?>