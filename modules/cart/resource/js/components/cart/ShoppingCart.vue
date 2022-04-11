<template>

    <div style="padding:15px">

        <div v-if="cartData!=null">

            <div class="checkout_tab" v-if="Object.keys(cartData['cart_types']).length>1">

                <v-tabs
                    v-model="tab"
                    color="#ef5661"
                >

                    <v-tab v-for="(type,key) in cartData['cart_types']" :key="key">
                        <div v-on:click="$store.commit('CartStore/change_show_tab',key)" :class="[ $store.state.CartStore.cart_type==key ? 'tab-item active' : 'tab-item']">
                            {{ type['title'] }}
                            <span class="shopping_cart_product_count" v-if="cartData['products'][key].length>0">{{ replaceNumber(cartData['products'][key].length) }}</span>
                        </div>
                    </v-tab>

                </v-tabs>


                <v-tabs-items v-model="tab">

                    <v-tab-item v-for="(array,cartType) in cartData['product_with_sending_type']" :key="cartType">

                        <component v-bind:is="'cart'+cartType" v-if="$store.state.CartStore.cart_type==cartType"
                                   :key="cartType"
                                   :login_status="login_status"
                        />

                    </v-tab-item>

                </v-tabs-items>

            </div>

            <div v-else-if="Object.keys(cartData['cart_types']).length===1">
                <component v-bind:is="'cart1'" v-if="$store.state.CartStore.cart_type==1"
                           :key="1"
                           :login_status="login_status"
                />
            </div>

            <div class="message_div" v-if="show_next_cart_message">

                <div class="message_box">
                    <p class="msg">با خرید این کالاها، بقیه کالاهای موجود در سبد خرید شما به “لیست خرید بعدی” منتقل می‌شوند.</p>
                    <a class="alert alert-success" v-on:click="approve_add_to_next_cart">تایید و ثبت سفارش</a>
                    <a class="alert alert-danger" v-on:click="show_next_cart_message=false,next_product_warranty_id=''">انصراف</a>
                </div>

            </div>

        </div>

        <v-dialog
            v-model="$store.state.CartStore.progress"
            persistent
            max-width="400px"
        >
            <v-card>

                <v-card-text>

                    <slot name="loading_box"></slot>

                    <div style="padding:30px 0px 10px 0px">
                        <v-progress-linear
                            color="red darken-1"
                            indeterminate
                            rounded
                            height="6"
                        ></v-progress-linear>
                    </div>


                </v-card-text>

            </v-card>
        </v-dialog>

    </div>

</template>

<script>
    import myMixin from "../../../../../../resources/js/myMixin";
    import cart1 from './cart1';
    import cart2 from './cart2';
    import CartStore from '../../store/CartStore';
    export default {
        name: "ShoppingCart",
        props:['cart_data','login_status','shop_product_url'],
        mixins:[myMixin],
        data(){
          return {
              tab: null,
              show_dialog_box:false,
              selected_product:null,
              add_to_next_cart_type:1,
              where_type:'whereNotIn',
              send_price_data:[],
          }
        },
        mounted() {
            this.$store.state.CartStore.cartData=this.cart_data;
            this.$store.state.shop_product_url=this.shop_product_url;
        },
        components:{
            cart1,cart2
        },
        computed:{
            cartData:function () {
                return this.$store.state.CartStore.cartData;
            },
        },
        created() {
            this.$store.registerModule('CartStore',CartStore);
        }
    }
</script>

<style>
    @import "../../style.css";
</style>

