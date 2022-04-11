<template>
    <div>

        <div v-if="Object.keys(cartData['product_with_sending_type'][2]).length>0  && cartData['product_with_sending_type'][2]['normal'] !=undefined && Object.keys(cartData['product_with_sending_type'][2]['normal']).length>0">

            <div class="page_row" v-for="(array,key) in cartData['product_with_sending_type'][2]['normal']">
                <price-change :changes_price="changes_price"></price-change>
                <div class="cart_content">
                    <div v-for="(array2,key2) in array">
                        <div v-if="key2=='product_key'" class="cart_item">
                            <div v-for="(index,key3) in array2" class="cart_row">
                                <mobile-cart-product-info
                                    :key="index"
                                    :priceVariation="cartData['products'][cartType][index]"
                                    @set_changes_price="change_price_fun"
                                >
                                    <div v-if="Object.keys(cartData['product_with_sending_type']).length==2" class="move-to-cart">
                                       <span v-on:click="$store.dispatch('CartStore/add_to_next_cart',[cartData['products'][cartType][index].id,1,'where'])" >
                                             افزودن به سبد خرید
                                        </span>
                                    </div>
                                </mobile-cart-product-info>
                            </div>
                        </div>

                        <div v-else>
                            <div v-for="(array3,key3) in array2" class="cart_item"  v-if="key3==='product_key'">
                                <mobile-sending-method  @set_sending_price="add_sending_price" :data="array2" :data_key="key2" :cartData="cartData" :cartType="cartType"></mobile-sending-method>
                                <div  v-for="(index,key4) in array3" class="cart_row">
                                    <mobile-cart-product-info
                                        :key="index"
                                        :priceVariation="cartData['products'][cartType][index]"
                                        @set_changes_price="change_price_fun"
                                    >
                                        <div v-if="Object.keys(cartData['product_with_sending_type']).length==2" class="move-to-cart">
                                           <span v-on:click="$store.dispatch('CartStore/add_to_next_cart',[cartData['products'][cartType][index].id,1,'where'])">
                                               افزودن به سبد خرید
                                           </span>
                                        </div>
                                    </mobile-cart-product-info>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div v-else class="page_row">
            <div class="empty-next-cart">
                <div class="c-checkout-empty-next-cart" :style="{backgroundImage:'url('+$siteUrl+'/modules/cart/06d51c65.png)'}"></div>
                <h5> لیست خرید بعدی شما خالی است! </h5>
                <p>
                    شما می‌توانید محصولاتی که به سبد خرید خود افزوده‌اید و فعلا قصد خرید آن‌ها را ندارید، در لیست خرید بعدی قرار داده و هر زمان مایل بودید آن‌ها را به سبد خرید اضافه کرده و خرید آن‌ها را تکمیل کنید.
                </p>
            </div>
        </div>

        <div class="message_div" v-if="$store.state.CartStore.show_dialog_box">
            <div class="message_box">
                <p id="msg">آیا مایل به حذف این محصول هستید ؟ </p>
                <a class="alert alert-success" v-on:click="approve">بله</a>
                <a class="alert alert-danger" v-on:click="$store.commit('CartStore/hide_dialog_box')">خیر</a>
            </div>
        </div>

    </div>

</template>

<script>
    import myMixin from "../../../../../../resources/js/myMixin";
    import events from "../../cartEvent";
    import MobileCartProductInfo from './MobileCartProductInfo'
    import MobileSendingMethod from './MobileSendingMethod';
    import PriceChange from "./PriceChange";
    export default {
        mixins:[myMixin,events],
        name: "mobileCart2",
        props:['login_status'],
        data(){
            return {
                sending_price:[],
                show_dialog_box:false,
                selected_price_variation:null,
                cart_type:2,
                where_type:'whereNotIn',
                priceVariation:null,
                show_next_cart_message:false,
                changes_price:[]
            }
        },
        components:{MobileCartProductInfo,MobileSendingMethod,PriceChange},
        methods:{
            add_sending_price:function (data,price) {
                this.sending_price.push({
                    title:data['title'],
                    icon:data['icon'],
                    price_type:data['price_type'],
                    price:price,
                });
            },
        },
        watch:{
            cartData:function () {
                this.changes_price=[];
            }
        },
        computed:{
            cartType:function () {
                return this.$store.state.CartStore.cart_type;
            },
            cartData:function () {
                return this.$store.state.CartStore.cartData;
            },
        }
    }
</script>

