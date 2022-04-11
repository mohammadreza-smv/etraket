<template>
    <div>
        <div v-if="has_changes_cart" class="alert alert-warning changes_cart">
            <span>توجه : قیمت یا موجودی بعضی از کالاهای سبد خرید شما تغییر کرده است</span>
            <a :href="$siteUrl+'/Cart'">مشاهده سبد خرید</a>
        </div>

        <button v-if="AddressLists.length==0" type="button" class="add_address_btn" v-on:click="show_address_box()" >
            <strong>ایجاد آدرس جدید</strong>
        </button>

        <div v-if="AddressLists.length>0" class="address_list">
            <div class="product_item_box mobile-default-address">
                <h6>تحویل گیرنده : {{ AddressLists[0]['name']}}</h6>
                <div class="address_content">
                    <div>آدرس : {{ AddressLists[0]['get_province']['name']}} {{ AddressLists[0]['get_city']['name']}} {{ AddressLists[0]['address']}} </div>
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

                    <a class="show_other_item" v-on:click="show_more_address()">
                        <span>تغییر آدرس ارسال</span>
                        <span class="fa fa-angle-left"></span>
                    </a>
                </div>
            </div>
        </div>

        <mobile-address-form  @setData="updateAddressList" @hideBox="hide_address_list_box()" ref="data"></mobile-address-form>

        <v-navigation-drawer
            v-model="show_address_list"
            fixed
            temporary
            width="100%"
            right
        >
            <v-app-bar
                fixed
                elevation="0"
            >
                <div style="padding-left:10px">
                    <v-icon @click="show_address_list=!show_address_list">mdi-arrow-right</v-icon>
                </div>

                <v-toolbar-title>انتخاب آدرس</v-toolbar-title>

            </v-app-bar>

            <div style="padding-top:90px"></div>

            <div class="content"  style="padding:10px">
                <button  type="button" class="add_address_btn" v-on:click="show_address_box()" >
                    <strong>ایجاد آدرس جدید</strong>
                </button>

                <div v-for="(address,key) in AddressLists">
                    <div class="product_item_box mobile-default-address">
                        <div class="address_item_header">
                            <h6>تحویل گیرنده : {{ address['name']}}</h6>
                            <div>
                                <v-icon v-on:click="showUpdateBox(address)">mdi-pencil-outline</v-icon>
                                <v-icon v-on:click="remove_address(address)">mdi-delete-outline</v-icon>
                            </div>
                        </div>
                        <div class="address_content">
                            <div>آدرس : {{ address['get_province']['name']}} {{ address['get_city']['name']}} {{ address['address']}} </div>
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

                            <a>
                                <span v-if="key==0" class="select_address_tag">سفارش به این آدرس ارسال می شود</span>
                                <span v-else class="select_address_tag" style="color: black" v-on:click="change_default_address(key)">ارسال سفارش به این آدرس</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </v-navigation-drawer>


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
    import MobileAddressForm from './MobileAddressForm';
    import methods from "../methods";
    export default {
        name: "AddressList",
        components:{MobileAddressForm},
        mixins:[methods],
        props:['data'],
        data(){
            return {
                AddressLists:[],
                show_address_list:false,
                show_default:true,
                show_dialog_box:false,
                remove_address_id:'',
                has_changes_cart:false
            }
        },
        mounted() {
            this.AddressLists=this.data;
            if(this.AddressLists.length>0)
            {
                this.$store.state.OrdersStore.city_id=this.AddressLists[0].city_id;

                this.$nextTick(function (){
                    this.$root.$emit('add_send_payment_page_data',{key:'address_id',value:this.AddressLists[0].id});
                    this.$root.$emit('add_send_payment_page_data',{key:'city_id',value:this.AddressLists[0].city_id});
                });
            }
        },
        methods:{
            show_more_address:function () {
                this.show_address_list=true;
            },
            change_default_address:function (key) {
                let old_array=this.AddressLists;
                const first=old_array[0];
                const select=old_array[key];

                this.$store.state.OrdersStore.city_id=select.city_id;

                this.$set(this.AddressLists,0,select);
                this.$set(this.AddressLists,key,first);
                this.show_default=true;
                this.$root.$emit('add_send_payment_page_data',{key:'address_id',value:select.id});
                this.$root.$emit('add_send_payment_page_data',{key:'city_id',value:select.city_id});
                this.show_address_list=false;
            },
            updateAddressList:function (data,key) {
                this.AddressLists=data;
                if(key!=undefined && key>0){

                }
                if(this.AddressLists.length===1){
                    this.$store.state.OrdersStore.city_id=this.AddressLists[0].city_id;
                    this.show_default=true;
                    this.$root.$emit('add_send_payment_page_data',{key:'address_id',value:this.AddressLists[0].id});
                    this.$root.$emit('add_send_payment_page_data',{key:'city_id',value:this.AddressLists[0].city_id});
                }
            },
            show_address_box:function(){
                this.show_address_list=false;
                this.$refs.data.setTitle('افزودن آدرس جدید');
            },
            ChangeCartStatus:function () {
                this.has_changes_cart=true;
            },
            showUpdateBox:function (address) {
                this.show_address_list=false;
                this.updateRow(address);
            }
        }
    }
</script>

<style>
    @import "../style.css";
</style>

