<template>
    <div class="order-address">

        <button v-if="AddressLists.length==0" type="button" class="add_address_btn" v-on:click="showModalBox()" data-target=".bd-example-modal-lg">
            <strong>ایجاد آدرس جدید</strong>
        </button>

        <div class="address_box box_border" v-if="show_address_list">


            <div class="select_address_label">
                <span>آدرس مورد نظر خود را جهت تحویل انتخاب فرمایید : </span>
                <span class="fa fa-close" v-on:click="close_address_list()"></span>
            </div>
            <button type="button" class="add_address_btn" v-on:click="showModalBox()" data-target=".bd-example-modal-lg">
                <strong>ایجاد آدرس جدید</strong>
            </button>


            <div class="address_row" v-for="(address,key) in  AddressLists" v-bind:key="address.id">
                <h4>{{ address['name'] }}</h4>
                <div class="checkout_address">
                    <span>{{ address['get_province']['name'] }}</span>
                    <span>{{ address['get_city']['name'] }}</span>
                    <span>{{ address['address']}}</span>
                </div>
                <ul>
                    <li>
                        <ul>
                            <li>
                                کد پستی :‌
                                <span>{{ replaceNumber(address['zip_code']) }}</span>
                            </li>
                            <li>
                                شماره همراه :‌
                                <span>{{ replaceNumber(address['mobile']) }}</span>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li>
                                <v-btn class="address_btn" @click="updateRow(address)" elevation="0">
                                    ویرایش
                                </v-btn>
                            </li>
                            <li>
                                <v-btn class="address_btn" @click="remove_address(address)" elevation="0">
                                    حذف
                                </v-btn>
                            </li>
                        </ul>
                    </li>
                </ul>

                <button :class="[ key==0 ? 'checkout_address_btn selected_address' : 'checkout_address_btn']" v-on:click="change_default_address(key)">
                    <span v-if="key==0">سفارش به این آدرس ارسال می شود</span>
                    <span v-else>ارسال سفارش به این آدرس</span>
                </button>
            </div>

        </div>

        <address-form  @setData="updateAddressList" ref="data"></address-form>

<!--        <mobile-address-form v-else  @setData="updateAddressList" ref="data" :paginate="'ok'"></mobile-address-form>-->

        <div v-if="show_default_address()">
            <div class="address_row default_address">

                <div style="padding-right:20px">

                    <ul>
                        <li>
                            <h4>{{ AddressLists[0]['name'] }}</h4>
                        </li>
                        <li>
                            <span class="data_link" v-on:click="updateRow(AddressLists[0])">اصلاح این آدرس</span>
                        </li>
                        <li class="change_address_btn">
                            <v-btn @click="change_address()" class="address_btn" elevation="0">
                                تغییر آدرس ارسال
                            </v-btn>
                        </li>
                    </ul>
                    <div class="checkout_address">
                        <span>{{ AddressLists[0]['get_province']['name'] }}</span>
                        <span>{{ AddressLists[0]['get_city']['name'] }}</span>
                        <span>{{ AddressLists[0]['address']}}</span>
                    </div>
                    <ul>
                        <li>
                            <ul>
                                <li>
                                    کد پستی :‌
                                    <span>{{ replaceNumber(AddressLists[0]['zip_code']) }}</span>
                                </li>
                                <li>
                                    شماره همراه :‌
                                    <span>{{ replaceNumber(AddressLists[0]['mobile']) }}</span>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <div class="checkout_contact">
                    <v-icon color="green">mdi-check</v-icon>
                </div>
            </div>

        </div>

        <v-dialog v-model="show_dialog_box" width="400px">
            <div class="address-dialog">
                <p id="msg">آیا مایل به حذف این آدرس هستید ؟ </p>

                <v-btn color="success" text @click="delete_address('ok')">
                    بله
                </v-btn>

                <v-btn color="error" text @click="show_dialog_box=false">
                    خیر
                </v-btn>
            </div>
        </v-dialog>

    </div>
</template>

<script>
    import AddressForm from './AddressForm';
    import methods from "../methods";
    import OrdersStore from "../../../../cart/resource/js/store/OrdersStore";
    export default {
        name: "AddressList",
        components:{AddressForm},
        mixins:[methods],
        props:['data'],
        data(){
            return {
                AddressLists:[],
                show_address_list:false,
                show_default:true,
                show_dialog_box:false,
                remove_address_id:'',

            }
        },
        mounted() {
            this.AddressLists=this.data;
            if(this.AddressLists.length>0)
            {

                this.$nextTick(function (){
                    this.$root.$emit('add_send_payment_page_data',{key:'address_id',value:this.AddressLists[0].id});
                    this.$root.$emit('add_send_payment_page_data',{key:'city_id',value:this.AddressLists[0].city_id});
                });

                this.$store.state.OrdersStore.city_id=this.AddressLists[0].city_id;
                this.$store.dispatch('OrdersStore/getCartData');
            }
        },
        methods:{
            close_address_list:function(){
                this.show_address_list=false;
                this.show_default=true;
            },
            show_default_address:function(){
                if(this.AddressLists.length>0 && this.show_default)
                {
                    return true;
                }
                else{
                    return  false;
                }
            },
            change_address:function () {
                this.show_default=false;
                this.show_address_list=true;
            },
            updateAddressList:function (data) {
                this.AddressLists=data;
                if(this.AddressLists.length===1){
                    this.$store.state.OrdersStore.city_id=this.AddressLists[0].city_id;
                    this.$store.dispatch('OrdersStore/getCartData');
                    this.show_default=true;
                    this.$root.$emit('add_send_payment_page_data',{key:'address_id',value:this.AddressLists[0].id});
                    this.$root.$emit('add_send_payment_page_data',{key:'city_id',value:this.AddressLists[0].city_id});

                }
            },
            change_default_address:function (key) {
                let old_array=this.AddressLists;
                const first=old_array[0];
                const select=old_array[key];

                this.$store.state.OrdersStore.city_id=select.city_id;
                this.$store.dispatch('OrdersStore/getCartData');

                this.$set(this.AddressLists,0,select);
                this.$set(this.AddressLists,key,first);
                this.show_address_list=false;
                this.show_default=this;
                this.$root.$emit('add_send_payment_page_data',{key:'address_id',value:select.id});
                this.$root.$emit('add_send_payment_page_data',{key:'city_id',value:select.city_id});

            }
        },
        created() {
            this.$store.registerModule('OrdersStore',OrdersStore);
        }
    }
</script>

<style>
    @import "../style.css";
</style>
