<template>
    <div class="submission_send_type" v-if="cartData.send_methods!=null">
        <div style="display: flex;align-items: center">
            <img v-bind:src="$siteUrl+'/files/upload/'+cartData.send_methods[data_key].icon">
            <span style="padding-right:10px">{{ cartData.send_methods[data_key].title }}</span>
            <span class="submission_product_count">({{ replaceNumber(data['product_key'].length) }} کالا)</span>
        </div>
        <div class="cart_send_price" v-if="cartType==1">
            <span>هزینه ارسال:</span>
            <span v-if="data.price_type==0">{{ getPrice(data.sending_price) }}</span>
            <span v-else>متغیر</span>
        </div>
        <div class="cart_send_price" v-else>
            <span v-on:click="$store.dispatch('CartStore/add_submission_to_next_cart',[data,1,'whereIn'])">افزودن همه به سبد خرید</span>
        </div>
    </div>
</template>

<script>
    import cartEvent from "../../cartEvent";
    export default {
        mixins:[cartEvent],
        name: "MobileSendingMethod",
        props:['data','data_key'],
        mounted() {
            if(this.cartData.send_methods!=null){
                this.$emit('set_sending_price',this.cartData.send_methods[this.data_key],this.data.sending_price)
            }
        }, computed:{
            cartType:function () {
                return this.$store.state.CartStore.cart_type;
            },
            cartData:function () {
                return this.$store.state.CartStore.cartData;
            },
        }
    }
</script>

