<template>
    <v-card style="margin-bottom:20px" class="brand-info-card">
        <v-card-text>
            <slot></slot>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: "BrandInfo",
    mounted() {
        this.$root.$emit('addLoadEvent','brand-detail');
    }
}
</script>

<style>
.brand-detail{
    display: flex;
    flex-direction: column;
    text-align: center;
}
.brand-detail img{
    width:130px;
    margin: auto;
    display: block;
}
.brand-detail a{
    color: black !important;
}
.brand-detail .brand-name{
    font-weight: bold;
    padding: 10px 0px;
    font-size: 17px;
}
@media (max-width:960px) {
    .brand-info-card{
        margin:10px !important;
    }
}
</style>
