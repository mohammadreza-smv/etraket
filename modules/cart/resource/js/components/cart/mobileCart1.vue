<template>
    <div>

        <div v-if="Object.keys(cartData['product_with_sending_type'][1]).length>0  && cartData['product_with_sending_type'][1]['normal'] !=undefined && Object.keys(cartData['product_with_sending_type'][1]['normal']).length>0">

            <div class="page_row" v-for="(array,key) in cartData['product_with_sending_type'][1]['normal']">
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
                                    <div v-if="Object.keys(cartData['product_with_sending_type']).length==2">
                                       <span v-on:click="$store.dispatch('CartStore/add_to_next_cart',[cartData['products'][cartType][index].id,2,'where'])" class="next-cart-link">
                                        ذخیره در سبد خرید بعدی
                                        </span>
                                    </div>
                                </mobile-cart-product-info>
                            </div>
                        </div>

                        <div v-else>
                            <div v-for="(array3,key3) in array2" class="cart_item"  v-if="key3==='product_key'">
                                <mobile-sending-method  @set_sending_price="add_sending_price" :data="array2" :data_key="key2" :cartData="cartData" :cartType="cartType"></mobile-sending-method>
                                <div v-for="(index,key4) in array3" class="cart_row">
                                    <mobile-cart-product-info
                                        :key="index"
                                        :priceVariation="cartData['products'][cartType][index]"
                                        :cartType="cartType"
                                        @change_product_count="change_product_count"
                                        @set_changes_price="change_price_fun"
                                    >
                                        <div v-if="Object.keys(cartData['product_with_sending_type']).length==2">
                                           <span v-on:click="$store.dispatch('CartStore/add_to_next_cart',[cartData['products'][cartType][index].id,2,'where'])" class="next-cart-link">
                                             ذخیره در سبد خرید بعدی
                                           </span>
                                        </div>
                                    </mobile-cart-product-info>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page_content">

                   <v-card>
                       <div class="order_info">
                           <ul>
                               <li>
                                   <div>
                                       <span>مبلغ کل </span>
                                       <span>({{ replaceNumber(cartData.products[1].length) }}) کالا</span>
                                   </div>
                                   <span class="left">{{ replaceNumber(number_format(cartData.total_price[1])) }} تومان</span>
                               </li>

                               <li class="cart_discount_li" v-if="(cartData.total_price[1]-cartData.cart_price[1])>0">
                                   <span>سود شما از خرید</span>
                                   <span class="left">{{ replaceNumber(number_format((cartData.total_price[1]-cartData.cart_price[1]))) }} تومان</span>
                               </li>

                               <li><span>هزینه ارسال</span></li>

                               <li v-for="item in sending_price">

                                   <div style="display: flex;align-items: center">
                                       <img class='cart-send-type-icon' v-bind:src="$siteUrl+'/files/upload/'+item.icon" />

                                       <span>{{ item.title }}</span>
                                   </div>
                                   <span class="left">
                                    <span v-if="item.price_type==0">
                                       {{ getPrice(item.price) }}
                                    </span>
                                     <span v-else>
                                       متغیر
                                     </span>
                                </span>
                               </li>

                           </ul>

                       </div>
                   </v-card>

                </div>

                <div style="padding-top:80px"></div>
                <div class="checkout-sticky">

                    <v-btn color="#ef394e" class="checkout-btn">
                        <a v-bind:href="$siteUrl+'/shipping'"  style="color:white">
                            ادامه فرایند خرید
                        </a>
                    </v-btn>


                    <div>
                        <div>مبلغ قابل پرداخت</div>
                        <div style="font-weight: bold;font-size:17px">
                            {{ replaceNumber(number_format(cartData.final_price[1]['normal'])) }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div v-else class="cart_table order_info empty_cart_div">
            <span class="fa fa-shopping-basket"></span>
            <span>سبد خرید شما خالیست !</span>
        </div>

        <delete-dialog></delete-dialog>

    </div>

</template>

<script>
    import events from "../../cartEvent";
    import MobileCartProductInfo from './MobileCartProductInfo'
    import MobileSendingMethod from './MobileSendingMethod';
    import PriceChange from "./PriceChange";
    import DeleteDialog from "./DeleteDialog";
    export default {
        mixins:[events],
        name: "mobileCart1",
        props:['login_status'],
        data(){
            return {
                sending_price:[],
                show_dialog_box:false,
                cart_type:1,
                where_type:'whereNotIn',
                priceVariation:null,
                changes_price:[]
            }
        },
        components:{DeleteDialog, MobileCartProductInfo,MobileSendingMethod,PriceChange},
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

