<template>
    <v-dialog
        width="900"
        v-model="$store.state.widget.styleBox"
        content-class="style-dialog"
    >

        <v-card>

            <v-card-title class="text-h6 header-dialog">
                <span>استایل ها</span>
                <div @click="$store.commit('widget/changeStyleDialogStatus')"><v-icon>mdi-close</v-icon></div>
            </v-card-title>

            <v-card-text>

                <v-tabs v-model="tab">
                    <v-tab v-if="hasSettingSlot()">تنظیمات ابزارک</v-tab>
                    <v-tab>پایه</v-tab>
                    <v-tab>ریسپانسیو</v-tab>

                </v-tabs>

                <v-tabs-items  v-model="tab">

                    <v-tab-item style="padding-top: 20px" v-if="hasSettingSlot()">

                        <slot name="setting_box"></slot>

                    </v-tab-item>

                    <v-tab-item style="padding-top: 20px">

                        <div class="row">

                            <div class="col-6">
                                <v-text-field
                                    label="عرض"
                                    outlined
                                    v-model="boxStyle.width"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-6">
                                <v-text-field
                                    label="ارتفاع"
                                    outlined
                                    v-model="boxStyle.height"
                                    dense
                                >
                                </v-text-field>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-4 color-box">
                                <v-menu offset-x >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            انتخاب رنگ پس زمینه
                                        </v-btn>
                                    </template>
                                    <v-color-picker
                                        dot-size="25"
                                        swatches-max-height="200"
                                        show-swatches
                                        v-model="boxStyle.backgroundColor"
                                    ></v-color-picker>
                                </v-menu>
                                <div style="display: flex;">
                                    <div :style="{backgroundColor:boxStyle.backgroundColor}" class="selected-color"></div>
                                    <a @click="boxStyle['backgroundColor']='transparent'">
                                        <v-icon >mdi-refresh</v-icon>
                                    </a>

                                </div>

                            </div>

                            <div class="col-4 color-box">

                                <v-menu offset-x>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            انتخاب رنگ متن
                                        </v-btn>
                                    </template>
                                    <v-color-picker
                                        dot-size="25"
                                        swatches-max-height="200"
                                        v-model="boxStyle.color"
                                        show-swatches
                                    ></v-color-picker>
                                </v-menu>
                                <div>
                                    <div :style="{backgroundColor:boxStyle.color}" class="selected-color"></div>
                                </div>

                            </div>

                            <div class="col-4">
                                <v-text-field
                                    label="نمایش متن در سمت"
                                    outlined
                                    v-model="boxStyle.textAlign"
                                    dense
                                    placeholder="right"
                                    hide-details
                                ></v-text-field>
                            </div>

                        </div>

                        <span style="margin-left:15px;margin-right:15px">فاصله خارجی</span>

                        <div class="row" >
                            <div class="col-3">
                                <v-text-field
                                    label="بالا"
                                    outlined
                                    v-model="boxStyle.marginTop"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="راست"
                                    outlined
                                    v-model="boxStyle.marginRight"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="پایین"
                                    outlined
                                    v-model="boxStyle.marginBottom"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="چپ"
                                    outlined
                                    v-model="boxStyle.marginLeft"
                                    dense
                                ></v-text-field>
                            </div>
                        </div>

                        <span style="margin-left:15px;margin-right:15px">فاصله داخلی</span>

                        <div class="row" >
                            <div class="col-3">
                                <v-text-field
                                    label="بالا"
                                    outlined
                                    v-model="boxStyle.paddingTop"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="راست"
                                    outlined
                                    v-model="boxStyle.paddingRight"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="پایین"
                                    outlined
                                    v-model="boxStyle.paddingBottom"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="چپ"
                                    outlined
                                    v-model="boxStyle.paddingLeft"
                                    dense
                                ></v-text-field>
                            </div>
                        </div>

                        <span style="margin-left:15px;margin-right:15px">radius</span>

                        <div class="row" >
                            <div class="col-3">
                                <v-text-field
                                    label="بالا-راست"
                                    outlined
                                    v-model="boxStyle.borderTopRightRadius"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="پایین - راست"
                                    outlined
                                    v-model="boxStyle.borderBottomRightRadius"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="پایین - چپ"
                                    outlined
                                    v-model="boxStyle.borderBottomLeftRadius"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="بالا - چپ"
                                    outlined
                                    v-model="boxStyle.borderTopLeftRadius"
                                    dense
                                ></v-text-field>
                            </div>
                        </div>

                        <div class="row border-row" >

                            <div class="col-6 color-box">

                                <v-menu offset-x>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                           انتخاب رنگ حاشیه
                                        </v-btn>
                                    </template>
                                    <v-color-picker
                                        dot-size="25"
                                        swatches-max-height="200"
                                        show-swatches
                                        v-model="boxStyle.borderColor"
                                    ></v-color-picker>
                                </v-menu>
                                <div>
                                    <div :style="{backgroundColor:boxStyle.borderColor}" class="selected-color"></div>
                                </div>

                            </div>

                            <div class="col-6">

                                <v-text-field
                                    label="عرض"
                                    outlined
                                    v-model="boxStyle.borderWidth"
                                    dense
                                ></v-text-field>

                            </div>

                        </div>

                        <div class="row" >

                           <div class="col-6">
                               <v-select
                                   :items="flexDirection"
                                   item-text="title"
                                   item-value="value"
                                   label="نوع چیدمان"
                                   outlined
                                   v-model="boxStyle.flexDirection"
                                   dense
                               ></v-select>
                           </div>

                            <div class="col-6">
                                <v-select
                                    :items="justifyContent"
                                    item-text="title"
                                    item-value="value"
                                    label="شیوه نمایش افقی محتوا"
                                    outlined
                                    v-model="boxStyle.justifyContent"
                                    dense
                                ></v-select>
                            </div>

                        </div>

                    </v-tab-item>

                    <v-tab-item style="padding-top: 20px">

                        <div class="row" >

                            <div class="col-6">
                                <v-select
                                    :items="responsiveWidth"
                                    item-text="title"
                                    item-value="value"
                                    label="استایل دهی برای"
                                    outlined
                                    v-model="responsive_type"
                                    dense
                                ></v-select>
                            </div>

                            <div class="col-6" >
                                <span>{{ page_width }}</span>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-6">
                                <v-text-field
                                    label="عرض"
                                    outlined
                                    v-model="responsive.width"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-6">
                                <v-text-field
                                    label="ارتفاع"
                                    outlined
                                    v-model="responsive.height"
                                    dense
                                >
                                </v-text-field>
                            </div>

                        </div>

                        <span style="margin-left:15px;margin-right:15px">فاصله خارجی</span>
                        <div class="row" >
                            <div class="col-3">
                                <v-text-field
                                    label="بالا"
                                    outlined
                                    v-model="responsive.marginTop"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="راست"
                                    outlined
                                    v-model="responsive.marginRight"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="پایین"
                                    outlined
                                    v-model="responsive.marginBottom"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="چپ"
                                    outlined
                                    v-model="responsive.marginLeft"
                                    dense
                                ></v-text-field>
                            </div>
                        </div>

                        <span style="margin-left:15px;margin-right:15px">فاصله داخلی</span>
                        <div class="row" >
                            <div class="col-3">
                                <v-text-field
                                    label="بالا"
                                    outlined
                                    v-model="responsive.paddingTop"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="راست"
                                    outlined
                                    v-model="responsive.paddingRight"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="پایین"
                                    outlined
                                    v-model="responsive.paddingBottom"
                                    dense
                                ></v-text-field>
                            </div>

                            <div class="col-3">
                                <v-text-field
                                    label="چپ"
                                    outlined
                                    v-model="responsive.paddingLeft"
                                    dense
                                ></v-text-field>
                            </div>
                        </div>

                        <div class="alert alert-primary responsive_item" v-if="responsiveItems.length>0">
                            <p v-for="item in responsiveItems">
                                <span>
                                    برای
                                </span>

                                <span v-if="item.type=='min'">
                                    حداقل عرض {{item.width  }}px
                                </span>

                                <span v-else-if="item.type=='max'">
                                    حداکثر عرض {{item.width  }}px
                                </span>

                                <span>
                                    استایل ثبت شده
                                </span>
                                <span class="link" v-on:click="$store.commit('widget/setDefaultResponsiveStyle',item)">مشاهده استایل ها</span>
                            </p>
                        </div>

                    </v-tab-item>

                </v-tabs-items>

            </v-card-text>

            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success" v-on:click="$store.commit('widget/setStyle',boxStyle)">
                    ثبت
                </v-btn>
            </v-card-actions>

        </v-card>

    </v-dialog>
</template>

<script>
    import { mapState } from 'vuex';
    export default {
        name: "StyleBox",
        data(){
            return {
               items:[],
               tab:'',
               flexDirection:[{'title':'ستون','value':'column'},{'title':'سطر','value':'row'}],
               justifyContent:[
                   {'title':'راست','value':'start'},
                   {'title':'چپ','value':'end'},
                   {'title':'فاصله برابر','value':'space-between'}
               ],
               responsiveWidth:[
                   {'title':'حداقل','value':'min'},{'title':'حداکثر','value':'max'}
               ],
               boxStyle:{}
            }
        },
        computed:mapState('widget',[
            'styleList',
            'responsive',
            'page_width',
            'responsiveItems',
            'responsive_type'
        ]),
        updated() {
            this.boxStyle=this.styleList;
        },
        methods:{
            hasSettingSlot() {
                return !!this.$slots.setting_box;
            }
        }
    }
</script>

<style>
    .color-box{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .selected-color{
        width: 30px;
        height: 30px;
        border-radius: 7px;
        -webkit-border-radius:7px;
        border:1px solid #f3f3f3;
        margin-right: 20px;
    }
    .style-dialog.v-text-field__details{
        display: none !important;
    }
    .style-dialog .text-h6{
        font-family: BYekan !important;
        display: flex;
        justify-content: space-between;
    }
    .style-dialog.v-text-field__details{
        display:none !important;
    }
</style>
