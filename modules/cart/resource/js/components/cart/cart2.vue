<template>
    <div>
        <div v-if="Object.keys(cartData['product_with_sending_type'][2]).length>0  && cartData['product_with_sending_type'][2]['normal'] !=undefined && Object.keys(cartData['product_with_sending_type'][2]['normal']).length>0">

            <div class="page_row" v-for="(array,key) in cartData['product_with_sending_type'][2]['normal']">
                <div class="page_content">
                    <price-change :changes_price="changes_price"></price-change>
                    <template v-if="array['product_key']!=undefined">
                        <div class="cart_item">
                            <table class="cart_table">
                                <cart-product-info  v-for="(index,key2) in array['product_key']"
                                                    :key="index"
                                                    :priceVariation="cartData['products'][cartType][index]"
                                                    @set_changes_price="change_price_fun"
                                >
                                    <li  class="move-to-cart">
                                         <span v-on:click="$store.dispatch('CartStore/add_to_next_cart',[cartData['products'][cartType][index].id,1,'where'])">
                                             افزودن به سبد خرید
                                         </span>
                                    </li>
                                </cart-product-info>
                            </table>
                        </div>
                    </template>
                    <template v-else>
                        <template v-for="(array2,key2) in array">
                            <div class="cart_item">
                                <sending-method  @set_sending_price="add_sending_price" :data="array2" :data_key="key2" :cartData="cartData" cart_type="2"></sending-method>
                                <table class="cart_table">
                                    <cart-product-info v-for="(index,key3) in array2['product_key']"
                                                       :key="index"
                                                       :priceVariation="cartData['products'][cartType][index]"
                                                       @set_changes_price="change_price_fun"
                                    >
                                        <li  class="move-to-cart">
                                             <span v-on:click="$store.dispatch('CartStore/add_to_next_cart',[cartData['products'][cartType][index].id,1,'where'])">
                                                 افزودن به سبد خرید
                                             </span>
                                        </li>
                                    </cart-product-info>
                                </table>
                            </div>
                        </template>
                    </template>
                </div>
                <div class="page_aside">
                    <div class="order_info next_cart_into">
                        <h5> لیست خرید بعدی چیست؟ </h5>
                        <p>
                            شما می‌توانید محصولاتی که به سبد خرید خود افزوده اید و موقتا قصد خرید آن‌ها را ندارید، در لیست خرید بعدی خود قرار داده و هر زمان مایل بودید آن‌ها را مجدداً به سبد خرید اضافه کرده و خرید آن‌ها را تکمیل کنید.
                        </p>
                    </div>
                </div>
            </div>

        </div>



        <div v-else :class="[ login_status==false ? 'empty_cart_div empty-next-cart' :'cart_table empty_cart_div']">
            <div>
                <div class="c-checkout-empty-next-cart" :style="{backgroundImage:'url('+$siteUrl+'/modules/cart/06d51c65.png)'}"></div>
                <h4> لیست خرید بعدی شما خالی است! </h4>
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
    import SendingMethod from "./SendingMethod";
    import CartProductInfo from "./CartProductInfo";
    import myMixin from "../../../../../../resources/js/myMixin";
    import events from "../../cartEvent";
    import PriceChange from './PriceChange'
    export default {
        name: "cart2",
        mixins:[myMixin,events],
        components: {SendingMethod, CartProductInfo,PriceChange},
        props:['login_status'],
        data(){
            return {
                sending_price:[],
                show_dialog_box:false,
                selected_price_variation:null,
                where_type:'whereNotIn',
                priceVariation:null,
                changes_price:[]
            }
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
