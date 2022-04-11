<template>
    <div v-if="show">
        <v-progress-linear indeterminate reverse height="6"></v-progress-linear>
        <div class="loading_box"></div>
    </div>
</template>

<script>
    export default {
        name: "Progress",
        data(){
            return {
                show:false,
                value:0
            }
        },
        mounted() {
            this.$root.$on('show_progress',()=>{
                this.show=true;
            });
            this.$root.$on('hide_progress',()=>{
                this.show=false;
            });
        }
    }
</script>

<style scoped>
    .loading_box{
        background-color: rgba(209, 209, 209, 0.49);
        position:fixed;
        top:10px;
        bottom:0px;
        left:0px;
        right:0px;
        width:100%;
        z-index:300000;
    }
</style>
