<v-tooltip bottom>
    <template v-slot:activator="{ on, attrs }">
        <a class="router-link" href="<?php echo e($url); ?>" style="padding-left:5px">
            <v-icon
                dark
                v-bind="attrs"
                v-on="on"
                color="black"
            >
                mdi-eye-outline
            </v-icon>
        </a>
    </template>
    <span>پیام های کاربر</span>
</v-tooltip>
<?php /**PATH /home/teraketc/AppCode/modules/messages/resource/views/panel/message_list_icon.blade.php ENDPATH**/ ?>