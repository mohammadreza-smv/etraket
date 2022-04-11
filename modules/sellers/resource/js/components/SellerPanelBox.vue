<template>
    <v-card
        elevation="1"
        :loading="loading"
        class="seller-panel"
        :disabled="loading"
    >
        <slot></slot>
    </v-card>
</template>

<script>
    export default {
        name: "SellerPanelBox",
        data(){
            return {
                loading:false
            }
        },
        mounted() {
            this.$root.$on('show_progress',()=>{
                this.loading=true;
            });
            this.$root.$on('hide_progress',()=>{
                this.loading=false;
                this.$nextTick(function () {
                    this.$root.$emit('setDrawerHeight');
                });
            });
        }
    }
</script>


