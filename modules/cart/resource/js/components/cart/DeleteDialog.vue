<template>
    <v-dialog v-model="$store.state.CartStore.show_dialog_box">
        <div class="message_box">
            <p id="msg">آیا مایل به حذف این محصول هستید ؟ </p>

            <v-btn color="success" text @click="$store.dispatch('CartStore/approve')">
                بله
            </v-btn>

            <v-btn color="error" text @click="$store.commit('CartStore/hide_dialog_box')">
                خیر
            </v-btn>
        </div>
    </v-dialog>
</template>

<script>
    export default {
        name: "DeleteDialog"
    }
</script>


