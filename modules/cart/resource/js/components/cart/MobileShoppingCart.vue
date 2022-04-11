<template>
    <div>

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
            </div>

            <v-tabs-items v-model="tab">
                <v-tab-item v-for="(array,cartType) in cartData['product_with_sending_type']" :key="cartType">

                    <component v-bind:is="'mobile-cart'+cartType" v-if="$store.state.CartStore.cart_type==cartType"
                               :key="cartType"
                               :login_status="login_status"
                    />
                </v-tab-item>

            </v-tabs-items>

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
    import mobileCart1 from './mobileCart1';
    import mobileCart2 from './mobileCart2';
    import CartStore from "../../store/CartStore";
    export default {
        props:['cart_data','login_status','shop_product_url'],
        components:{mobileCart1,mobileCart2},
        mixins:[myMixin],
        data(){
            return {
                show_dialog_box:false,
                selected_product:null,
                add_to_next_cart_type:1,
                where_type:'whereNotIn',
                send_price_data:[],
                tab: null
            }
        },
        mounted() {
            this.$store.state.CartStore.cartData=this.cart_data;
            this.$store.state.shop_product_url=this.shop_product_url;
        },
        computed:{
            cartData:function () {
                return this.$store.state.CartStore.cartData;
            },
            shopCartType:function () {
                return this.$store.state.CartStore.cart_type;
            }
        },
        created() {
            this.$store.registerModule('CartStore',CartStore);
        }
    }
</script>

<style>
    @import "../../style.css";
</style>
