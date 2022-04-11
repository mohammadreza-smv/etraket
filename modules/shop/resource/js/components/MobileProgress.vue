<template>
    <div v-if="show">
        <div class="mobile-progress-box">
            <v-progress-circular
                indeterminate
                color="red"
            ></v-progress-circular>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MobileProgress",
        data(){
            return {
                show:false
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
    .mobile-progress-box{
        background-color:white;
        position:fixed;
        top:59px;
        bottom:0px;
        left:0px;
        right:0px;
        width:100%;
        z-index:300000;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
