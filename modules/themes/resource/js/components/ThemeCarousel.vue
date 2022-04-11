<template>
    <v-carousel
        v-model="model"
        hide-delimiter-background
        height="100%"
        cycle
        class="theme-slide"

    >
         <slot></slot>

    </v-carousel>
</template>

<script>
    export default {
        name: "ThemeCarousel",
        data(){
            return {
                model:0
            }
        },
        mounted() {
            this.$nextTick(function () {
                this.$root.$emit('addLoadEvent','theme-slide');
            });
        }
    }
</script>

<style>
    @import "../theme.css";
</style>
