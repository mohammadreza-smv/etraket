<template>
    <v-card class="seller-page-info">
        <v-card-text style="padding: 0px">
            <div class="seller_profile_box_header"><div class="avatar"></div></div>
            <slot name="seller-page-info"></slot>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: "SellerPageInfo"
}
</script>

<style>
@import "../style.css";
</style>
