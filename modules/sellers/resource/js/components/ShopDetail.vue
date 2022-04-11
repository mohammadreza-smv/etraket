<template>

    <div class="shop_name" v-if="product.status==1 && product.first_product_price!=null">
        فروشنده :
        {{ product.first_product_price.seller.brand_name }}
    </div>

</template>

<script>
    export default {
        name: "ShopDetail",
        props:['product']
    }
</script>

