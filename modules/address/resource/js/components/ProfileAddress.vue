<template>

    <div>
        <v-card elevation="0" style="border:0px;" :disabled="loading">

            <button  class="add_address_btn profile_address_btn" style="margin-bottom:20px;"
                     @click="showModalBox()">
                <v-icon color="#a0a0a0" size="30">mdi-plus</v-icon>
                <span>ایجاد آدرس جدید</span>
            </button>


            <div class="profile-address-cart" v-for="(address,key) in  AddressLists.data" v-bind:key="address.id">
                <div class="profile-address-cart-desc">
                    <h4>{{ address['name'] }}</h4>
                    <p>{{ address['address']}}</p>
                </div>
                <div class="profile-address-cart-data">
                    <ul>
                        <li>
                            <v-icon>mdi-email</v-icon>
                            <span>کد پستی :‌ {{ replaceNumber(address['zip_code']) }}</span>
                        </li>
                        <li>
                            <v-icon>mdi-cellphone</v-icon>
                            <span>تلفن همراه : {{ replaceNumber(address['mobile']) }}</span>
                        </li>
                    </ul>
                    <ul style="display:inline-flex" class="btn_ul">
                        <li>
                            <v-btn
                                @click="updateRow(address)"
                                color="#00bfd6"
                                class="address_btn"
                            >
                                ویرایش
                            </v-btn>
                        </li>
                        <li style="margin-right:10px">
                            <v-btn
                                @click="remove_address(address)"
                                color="error"
                                class="address_btn"
                            >
                                حذف
                            </v-btn>
                        </li>
                    </ul>
                </div>
            </div>

            <vue-pagination
                :pagination="AddressLists"
                @paginate="getAddress"
                :offset="5"
            >

            </vue-pagination>


        </v-card>

        <address-form v-if="layout!=='mobile'"  @setData="updateAddressList" ref="data" :paginate="'ok'"></address-form>

        <mobile-address-form v-else  @setData="updateAddressList" ref="data" :paginate="'ok'"></mobile-address-form>

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

        <v-dialog
            v-model="loading"
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
  import methods from "../methods";
  import AddressForm from './AddressForm';
  import MobileAddressForm from './MobileAddressForm';
  import VuePagination from "./VuePagination";
  export default {
        name: "ProfileAddress",
        components:{AddressForm,MobileAddressForm,VuePagination},
        mixins:[methods],
        props:['layout'],
        data(){
            return {
                AddressLists:{data:[]},
                show_dialog_box:false,
                loading:false
            }
        },
        mounted() {
           this.getAddress();
        },
        methods:{
            getAddress:function(page=1){
                this.loading=true;
                const url=this.$siteUrl+"/user/getAddress?page="+page;
                this.axios.get(url).then(response=>{
                    this.AddressLists=response.data;
                    this.loading=false;
                }).catch(error=>{
                    this.loading=false;
                });
            },
            updateAddressList:function (data) {
                 this.AddressLists=data;
            },
        }
 }
</script>

<style>
    @import "../style.css";
</style>

