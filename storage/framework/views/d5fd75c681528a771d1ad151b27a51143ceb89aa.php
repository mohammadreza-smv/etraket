<a onclick="vm.$root.$emit('send_get_request','<?php echo e(url('compare/dkp-'.$product->id)); ?>')">
    <v-tooltip left>

        <template v-slot:activator="{ on, attrs }">
            <div>
                <v-icon
                    color="gray"
                    v-on="on"
                >
                    mdi-arrow-collapse
                </v-icon>
            </div>
        </template>
        <span>افزودن به لیست مقایسه</span>

    </v-tooltip>
</a>
<?php /**PATH /home/teraketc/AppCode/modules/productComparison/resource/views/product-page-link.blade.php ENDPATH**/ ?>