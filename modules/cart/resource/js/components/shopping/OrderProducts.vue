<template>
    <div class="page_row">

        <div class="page_content">
            <slot name="header"></slot>
            <template v-if="Object.keys(cartData).length>0">

                <div id="send_order_type_box">

                    <v-radio-group v-model="radioGroup">
                        <div v-if="Object.keys(cartData['product_with_sending_type'][1]).length>1">
                            <h6>انتخاب نحوه ارسال</h6>
                            <div class="shipping_data_box">
                                <p v-for="(type,key) in cartData['sending_type']" @click="change_send_type(key)">
                                    <v-radio
                                        :label="type"
                                        :value="key"
                                    ></v-radio>

                                </p>
                            </div>
                        </div>
                    </v-radio-group>

                    <div v-for="(array,key) in cartData['product_with_sending_type'][1][send_type]">
                        <div v-for="(array2,key2,index) in array">
                            <div v-if="key2==='product_key'">
                                <submission-product :data="array2" submission_info="" type_key=""></submission-product>
                            </div>
                            <div v-else>
                                <div v-for="(array3,key3) in array2" v-if="key3==='product_key'">
                                    <submission-product :data="array3" :submission_info="array2" :type_key="key2"></submission-product>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="shipping_data_box" style="padding:5px 20px 15px 30px">

                    <v-checkbox
                        label="درخواست ارسال فاکتور خرید"
                        hide-details
                    ></v-checkbox>

                </div>

                <ul class="checkout_action" v-if="checkout_action">
                    <li>
                        <a class="data_link router-link" v-bind:href="$siteUrl+'/Cart'">
                            بازگشت به سبد خرید
                        </a>
                    </li>

                    <li>
                        <a class="data_link" @click="goToPaymentPage">
                            تایید و ادامه ثبت سفارش
                        </a>
                    </li>
                </ul>

                <a v-else  @click="goToPaymentPage">
                    <div class="add_product_link">
                        <span>ادامه ثبت سفارش</span>
                    </div>
                </a>

            </template>
        </div>

        <div class="page_aside">
            <div class="order_info" style="margin-top: 0px">
                <slot name="checkout-items"></slot>
                <div v-if="type!=='mobile'">
                    <v-btn class="send_btn" @click="goToPaymentPage">
                        ادامه ثبت سفارش
                    </v-btn>

                </div>
            </div>
        </div>

        <div v-if="type==='mobile'" style="padding-top:80px"></div>
        <div class="checkout-sticky" v-if="type==='mobile'" style="padding:0px 10px 0px 30px;">

            <v-btn color="#ef394e" class="checkout-btn" @click="goToPaymentPage">
                ادامه ثبت سفارش
            </v-btn>

            <div >
                <div>مبلغ قابل پرداخت</div>
                <div style="font-weight: bold;font-size:17px" v-if="cartData['final_price']!==undefined">
                    {{ replaceNumber(number_format(cartData.final_price[1]['normal'])) }}
                </div>
            </div>

        </div>

    </div>
</template>

<script>
    import {createNamespacedHelpers} from 'vuex';
    import cartEvent from "../../cartEvent";
    const {mapActions,mapMutations} =createNamespacedHelpers('OrdersStore');
    import SubmissionProduct from './SubmissionProduct';
    import OrdersStore from "../../store/OrdersStore";
    export default {
        mixins:[cartEvent],
        name: "OrderProducts",
        data(){
            return {
                checkout_action:true,
                radioGroup: 'normal',
                sendPaymentPageData:{}
            }
        },
        mounted() {
            this.checkout_action=this.mobile==='ok' ? false: true;
            this.$root.$on('add_send_payment_page_data',(payload)=>{
                this.sendPaymentPageData[payload.key]=payload.value;
            });
            this.getCartData();
        },
        props:['type'],
        methods:{
            ...mapActions([
                'getCartData',
                'change_send_type'
            ]),
        },
        computed:{
            cartData:function () {
                return this.$store.state.OrdersStore.cartData;
            },
            send_type:function () {
                return this.$store.state.OrdersStore.send_type;
            }
        },
        components:{SubmissionProduct},
        created() {
            this.$store.registerModule('OrdersStore',OrdersStore);
        }
    }
</script>
<style>
    @import "../../style.css";
</style>

