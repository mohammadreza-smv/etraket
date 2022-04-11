<template>
    <div>
        <div v-if="Object.keys(cartData['product_with_sending_type'][1]).length>0 && cartData['product_with_sending_type'][1]['normal'] !=undefined && Object.keys(cartData['product_with_sending_type'][1]['normal']).length>0">

            <div class="page_row" v-for="(array,key) in cartData['product_with_sending_type'][1]['normal']">
                <div class="page_content">

                    <price-change :changes_price="changes_price"></price-change>

                    <template v-if="array['product_key']!=undefined">
                        <div class="cart_item">
                            <table class="cart_table">
                                <cart-product-info
                                    v-for="(index,key2) in array['product_key']"
                                    :key="index"
                                    :priceVariation="cartData['products'][cartType][index]"
                                    @set_changes_price="change_price_fun"
                                >
                                    <li v-if="Object.keys(cartData['product_with_sending_type']).length==2 ">
                                         <span v-on:click="$store.dispatch('CartStore/add_to_next_cart',[cartData['products'][cartType][index].id,2,'where'])" class="next-cart-link">
                                            ذخیره در سبد خرید بعدی
                                         </span>
                                    </li>
                                </cart-product-info>
                            </table>
                        </div>
                    </template>
                    <template v-else>
                            <template v-for="(array2,key2) in array">
                                 <div class="cart_item">
                                     <sending-method  @set_sending_price="add_sending_price" :data="array2" :data_key="key2" :cartData="cartData" cart_type="1"></sending-method>
                                     <table class="cart_table">
                                      <cart-product-info
                                          v-for="(index,key3) in array2['product_key']"
                                          :key="index"
                                          :priceVariation="cartData['products'][cartType][index]"
                                          @set_changes_price="change_price_fun"
                                       >
                                        <li v-if="Object.keys(cartData['product_with_sending_type']).length==2">
                                            <span v-on:click="$store.dispatch('CartStore/add_to_next_cart',[cartData['products'][cartType][index].id,2,'where'])" class="next-cart-link">
                                               ذخیره در سبد خرید بعدی
                                            </span>
                                        </li>
                                      </cart-product-info>
                                     </table>
                                </div>
                            </template>
                    </template>

                </div>
                <div class="page_aside">
                    <div class="order_info" >
                        <ul>
                            <li>
                                <div>
                                    <span>مبلغ کل </span>
                                    <span>({{ replaceNumber(cartData.products[1].length) }}) کالا</span>
                                </div>
                                <span>{{ replaceNumber(number_format(cartData.total_price[1])) }} تومان</span>
                            </li>


                            <li class="cart_discount_li" v-if="(cartData.total_price[1]-cartData.cart_price[1])>0">
                                <span>سود شما از خرید</span>
                                <span>{{ replaceNumber(number_format((cartData.total_price[1]-cartData.cart_price[1]))) }} تومان</span>
                            </li>



                            <li v-if="sending_price.length>0"><span>هزینه ارسال</span></li>

                            <li v-for="item in sending_price">

                                <div style="display: flex;align-items: center">
                                    <img class='cart-send-type-icon' v-bind:src="$siteUrl+'/files/upload/'+item.icon" />

                                    <span>{{ item.title }}</span>
                                </div>

                                <span>
                                   <span v-if="item.price_type==0">
                                       {{ getPrice(item.price) }}
                                   </span>
                                   <span v-else>
                                       متغیر
                                   </span>
                                </span>
                            </li>

                            <template v-if="cartData['checkoutItems']!=undefined">
                                <li v-for="item in cartData['checkoutItems']" :style="{ 'display':item.display }" :class="item.name">
                                    <span>{{ item.title }}</span>
                                    <span>{{ item.value }}</span>
                                </li>
                            </template>

                        </ul>

                        <div class="checkout_devider"></div>
                        <div class="checkout_content">
                            <p style="color:red">مبلغ قابل پرداخت : </p>
                            <p>{{ replaceNumber(number_format(cartData.final_price[1]['normal'])) }} </p>
                        </div>
                        <v-btn class="send_btn">
                            <a v-bind:href="$siteUrl+'/shipping'"  style="color:white">
                                ادامه ثبت سفارش
                            </a>
                        </v-btn>
                    </div>
                </div>
            </div>

        </div>


        <div class="cart_table empty_cart_div" v-else>
            <div>
                <p>
                    <v-icon size="70">mdi-shopping-outline</v-icon>
                </p>
                <p>سبد خرید شما خالیست !</p>
            </div>
        </div>


        <delete-dialog></delete-dialog>

    </div>
</template>

<script>
    import './CartProductInfo'
    import CartProductInfo from "./CartProductInfo";
    import SendingMethod from "./SendingMethod";
    import myMixin from "../../../../../../resources/js/myMixin";
    import events from '../../cartEvent';
    import PriceChange from "./PriceChange";
    import DeleteDialog from "./DeleteDialog";
    export default {
        mixins:[myMixin,events],
        name: "cart1",
        components: {DeleteDialog, PriceChange, SendingMethod, CartProductInfo},
        props:['product_data','login_status'],
        data(){
            return {
                sending_price:[],
                show_dialog_box:false,
                selected_price_variation:null,
                where_type:'whereNotIn',
                priceVariation:null,
                show_next_cart_message:false,
                changes_price:[]
            }
        },
        methods:{
            add_sending_price:function (data,price) {
               this.sending_price.push({
                   title:data['title'],
                   icon:data['icon'],
                   price_type:data['price_type'],
                   price:price,
               });
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

