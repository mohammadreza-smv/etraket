<template>
    <div>

        <v-dialog
            v-model="show_address_dialog"
            width="630"
        >
            <v-card  class="address-form" :loading="loading">

                <v-card-title class="headline lighten-2">
                    <h5>{{ title }}</h5>

                    <v-icon @click="show_address_dialog=false">mdi-close</v-icon>

                </v-card-title>

                <v-card-text>
                    <div v-if="step===1">

                        <div style="width: 580px;height:400px;position: relative">
                            <l-map :center="center" :zoom="16"  ref="myMap" @dragend="changeMorkerPosition()"  @drag="changeMorkerPosition()">
                                <LTileLayer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"></LTileLayer>
                                <LMarker :lat-lng="center2">
                                    <l-icon >
                                        <img :src="this.$siteUrl+'/modules/address/map_location.svg'">
                                    </l-icon>
                                </LMarker>
                            </l-map>

                            <div class="search-field">

                                <v-text-field
                                    outlined
                                    label="جستجو آدرس"
                                    @input="searchAddress()"
                                    hide-details
                                    v-model="searchText"
                                    solo
                                    clearable
                                    @click:clear="closeSearchBox=true"
                                    :loading="searchRequest"
                                >

                                </v-text-field>

                                <div v-if="areas.length>0 && closeSearchBox===false" class="search-content" >
                                    <div v-for="area in areas" style="font-size:14px;padding: 5px;cursor:pointer" v-on:click="setLocation(area)">
                                        {{ area.address }}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <v-divider></v-divider>

                    </div>

                    <div v-else-if="step===2">

                        <div class="row" v-if="server_error">
                            <v-alert
                                type="warning"
                                width="100%"
                            >
                                خطا در ارسال اطلاعات مجددا تلاش نمایید
                            </v-alert>
                        </div>

                        <v-form
                            ref="form"
                            v-model="valid"
                            lazy-validation
                        >
                            <div id="add_address_box">

                                <div class="row">
                                    <div class="col-6">
                                        <v-text-field
                                            outlined
                                            label="نام و نام خانوادگی تحویل گیرنده"
                                            v-model="name"
                                            dense
                                            :rules="nameRules"
                                        >
                                        </v-text-field>
                                    </div>
                                    <div class="col-6">
                                        <v-text-field
                                            outlined
                                            label="شماره موبایل"
                                            v-model="mobile"
                                            dense
                                            :rules="[mobileRules,validateMobileNumber]"
                                        >
                                        </v-text-field>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-6">
                                        <v-combobox
                                            label="استان"
                                            outlined
                                            dense
                                            return-object
                                            v-model="province_select"
                                            :items="province"
                                            item-value="name"
                                            item-text="name"
                                            @change="getCity"
                                            :rules="provinceRules"
                                        ></v-combobox>
                                    </div>

                                    <div class="col-6">
                                        <v-combobox
                                            label="شهر"
                                            outlined
                                            dense
                                            v-model="city_select"
                                            :items="city"
                                            item-text="name"
                                            item-value="id"
                                            return-object
                                            @change="set_city_id"
                                            :rules="cityRules"
                                        ></v-combobox>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <v-textarea
                                            v-model="address"
                                            outlined
                                            label="آدرس پستی"
                                            :rules="addressRules"
                                        >

                                        </v-textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <v-text-field
                                            outlined
                                            label="کد پستی"
                                            v-model="zip_code"
                                            dense
                                            :rules="[zipCodeRules,validateZipCode]"
                                        >
                                        </v-text-field>
                                    </div>
                                </div>

                            </div>
                        </v-form>

                    </div>


                </v-card-text>


                <v-card-actions>
                    <div>
                        <span>مرسوله شما به این موقعیت ارسال خواهد شد.</span>
                    </div>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="#ef394e"
                        @click="set_address_detail"
                        class="address-detail"
                    >
                        <span  v-if="step===1">تایید و افزودن جزییات</span>
                        <span  v-else>تایید و ثبت آدرس</span>
                    </v-btn>
                </v-card-actions>

            </v-card>
        </v-dialog>

    </div>
</template>

<script>
    import { LMap, LTileLayer, LMarker,LIcon } from 'vue2-leaflet';
    import 'leaflet/dist/leaflet.css';
    import methods from "../methods";
    export default {
        name: "AddressFrom",
        data(){
            return{
                show_address_dialog:false,
                id:0,
                name:'',
                mobile:'',
                province_id:'',
                city_id:'',
                address:'',
                zip_code:'',
                province:[],
                city:[],
                title:'افزودن آدرس جدید',
                btn_text:'ثبت و ارسال به این آدرس',
                server_error:false,
                get_page:'no',
                center: [38.0718603, 46.2842501],
                center2: [38.0718603, 46.2842501],
                areas:[],
                searchRequest:false,
                newSearchText:'',
                apiKey:"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE0MzIzZTE3Mzc3NTMyNTY3NzNlMTdhZTNhNTkxYmRlM2I3M2EzMWQ5NGU5NTJiNTgxODQ2YTI4YThiM2YwY2Q5NTY2ZTg0MDYwMjliZGRiIn0.eyJhdWQiOiI5MzkxIiwianRpIjoiMTQzMjNlMTczNzc1MzI1Njc3M2UxN2FlM2E1OTFiZGUzYjczYTMxZDk0ZTk1MmI1ODE4NDZhMjhhOGIzZjBjZDk1NjZlODQwNjAyOWJkZGIiLCJpYXQiOjE1OTA0ODA0NDksIm5iZiI6MTU5MDQ4MDQ0OSwiZXhwIjoxNTkzMDcyNDQ5LCJzdWIiOiIiLCJzY29wZXMiOlsiYmFzaWMiXX0.HMVuhLq9VEZjUwnA3P3B8u4otW_KrndIDW-teSGyDLj-NQ4x1JmynkMYIYmGXvVirh-tZ5G67xVhgj_dCmKp0Xm5dbQRnpBp-EKNCZkbSvADwjzkhxiao68_lrEZ3-M8Et4rjO0A_mVLnE_Owyc8ZqPjdrhZlr-2DdM9P_n9mjp7YxgUr2EU16G7Ibn9KizIDX7U_mhvgy1pJTk4sRokW5r9DNM5K9nO1V3S8vTpXEntY0zqFBDisDCdwRo2QJYgpOEL8ehmcVeYPKxd5Tg8FUB8ShkS0qQQgOGBqhlAbp6ae_5JU9q8uU-BCnphhh5fj9bihfe6C1ZEPlrxOf3COg",
                step:1,
                getAddressDetail:false,
                searchAddressLoading: false,
                searchText:'',
                closeSearchBox:true,
                valid:null,
                nameRules: [
                    v => !!v || 'نام و نام خانوادگی نمی تواند خالی باشد',
                    v => (v && v.length > 6) || 'نام و نام خانوادگی حداقل باید شامل ۶ کاراکتر باشد',
                ],
                mobileRules: [
                    v => !!v || 'لطفا شماره موبایل خود را وارد نمایید',
                ],
                province_select:null,
                city_select:null,
                provinceRules: [
                    v => !!v || 'لطفا استان را انتخاب نمایید',
                ],
                cityRules: [
                    v => !!v || 'لطفا شهر را انتخاب نمایید',
                ],
                addressRules: [
                    v => !!v || 'آدرس نمی تواند خالی باشد',
                    v => (v && v.length > 10) || 'آدرس وارد شده کوتاه است',
                ],
                zipCodeRules: [
                    v => !!v || 'کد پستی نمی تواند خالی باشد',
                ],
                loading:false
            }
        },
        mixins:[methods],
        props:['paginate'],
        components: {
            LMap,
            LTileLayer,
            LMarker,
            LIcon
        },
        mounted() {
            this.getProvince();
            const self=this;
            this.get_page=this.paginate==='ok' ? 'ok' : 'no';
        },
        methods:{
            setUpdateData:function (address,title) {
                const self=this;
                this.btn_text='ویرایش';
                this.id=address.id;
                this.name=address.name;
                this.mobile=address.mobile;
                this.city_id=address.city_id;
                this.province_id=address.province_id;
                this.address=address.address;
                this.zip_code=address.zip_code;
                this.title=title;
                if(this.province_id>0){
                    for (let i = 0; i < this.province.length ; i++) {
                        if(this.province[i]['id']===this.province_id){
                            this.province_select=this.province[i]['name'];
                        }
                    }
                    this.getCity(undefined,this.province_id);
                }
                else{
                    this.cityList=[];
                }
                this.step=1;
                this.center=[address.lat,address.lng];
                this.center2=[address.lat,address.lng];
                this.show_address_dialog=true;
                this.$nextTick(function () {
                    setTimeout(function () {
                        if(self.$refs.myMap!==undefined){
                            self.$refs.myMap.mapObject.invalidateSize();
                        }
                    },100);
                });
            },
            setTitle:function (title) {
                this.title=title;
                this.id='';
                this.name='';
                this.mobile='';
                this.city_id='';
                this.province_id='';
                this.address='';
                this.zip_code='';
                this.btn_text='ثبت و ارسال به این آدرس';
                this.show_address_dialog=true;
                const self=this;
                this.step=1;
                this.province_select=null;
                this.city_select=null;
                this.$nextTick(function () {
                    setTimeout(function () {
                        if(self.$refs.myMap!==undefined){
                            self.$refs.myMap.mapObject.invalidateSize();
                        }
                        self.get_my_location();
                    },100);
                });

            }
        },
        watch:{
            center2:function (newVal,oldVal) {
                this.getAddressDetail=true;
            },
        }
    }
</script>

