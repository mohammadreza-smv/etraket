<template>
    <ul class="color_box list-inline">
        <li v-for="(color,key) in product.product_color" v-if="color.get_color!=null && key<3">
            <label :style="{background:'#'+color.get_color.code}"></label>
        </li>

        <li v-if="product.product_color.length>3">
            <v-icon>mdi-plus</v-icon>
        </li>
    </ul>
</template>

<script>
    export default {
        name: "ProductColorList",
        props:['product']
    }
</script>

<style scoped>
    .color_box{
        position: absolute;
        margin-right: 10px;
    }
    .color_box li{
        height: 15px !important;
    }
    .color_box li label{
        width: 10px;
        height: 10px;
        border-radius: 10px;
        -webkit-border-radius: 10px;
        border:1px solid rgba(128, 128, 128, 0.24);
        display: block;
    }
    .color-code{
        padding:10px 20px;
    }
</style>
