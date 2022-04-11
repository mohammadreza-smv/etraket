<template>
    <div class="mobile-gallery-box">
        <v-carousel
            cycle
            height="300"
            hide-delimiter-background
            :show-arrows="false"
        >

            <slot></slot>

        </v-carousel>
    </div>

</template>

<script>
    export default {
        name: "MobileGallery"
    }
</script>

<style>
    @import "../../assets/css/style.css";
</style>
