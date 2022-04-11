<template>
    <div>
        <v-navigation-drawer
            width="300" app permanent right class="right_box"
            v-if="showDrawer"
        >
            <h5>ثبت نام در مرکز فروشندگان</h5>
            <div class="content">
                <ul class="step_ul">
                    <li>
                        <div :class="step<3 ? 'step_active_icon' : 'step_inactive_icon'">
                            <v-icon>mdi-account-outline</v-icon>
                        </div>
                        <span class="step_header">۱. اطلاعات فروشنده</span>
                        <p>اطلاعات شخصی فروشنده، اطلاعات تجاری، اطلاعات تماس</p>
                    </li>
                    <li>
                        <div :class="step===3 ? 'step_active_icon' : 'step_inactive_icon'">
                            <v-icon>mdi-cellphone</v-icon>
                        </div>
                        <span class="step_header">۲. تایید شماره موبایل</span>
                        <p>تایید شماره موبایل ثبت شده</p>
                    </li>
                    <li>
                        <div :class="step===4 ? 'step_active_icon' : 'step_inactive_icon'">
                            <v-icon>mdi-cloud-upload-outline</v-icon>
                        </div>
                        <span class="step_header">۳. بارگذاری مدارک</span>
                        <p>ارسال تصویر مدارک شخصی و تجاری</p>
                    </li>
                    <li>
                        <div :class="step===5 ? 'step_active_icon last_step_active_icon' : 'step_inactive_icon last_step'">
                            <v-icon>mdi-basket-outline</v-icon>
                        </div>
                        <span class="step_header">۴. اتمام ثبت نام</span>
                        <p>به جمع فروشندگان ما خوش آمدید</p>
                    </li>
                </ul>
            </div>

        </v-navigation-drawer>


        <v-main>
            <div class="register_form_box" style="flex-direction: column;">
                <v-card style="width:485px;text-align: center;background:transparent" elevation="0" :disabled="showLoading" >
                    <div style="padding-top:10px"></div>

                    <v-alert type="error" v-if="server_error">
                        {{ server_error }}
                    </v-alert>

                    <div :style="{display:step===1 ? 'block' : 'none'}">
                        <slot v-if="step===1" name="register-1"></slot>
                    </div>

                    <div :style="{display:step===2 ? 'block' : 'none'}">
                        <slot name="register-2" :mobile="mobile"></slot>
                    </div>

                    <div :style="{display:step===3 ? 'block' : 'none'}">
                        <slot name="register-3" :mobile="mobile"></slot>
                    </div>

                    <div :style="{display:step===4 ? 'block' : 'none'}" class="file-box">
                        <slot :name="'upload-file-'+account_type" :mobile="mobile" ></slot>
                    </div>

                    <div :style="{display:step===5 ? 'block' : 'none'}">
                        <v-alert type="success">
                            به جمع فروشندگان {{ shop_name }} خوش آمدید
                            <p>
                                با استفاده از اطلاعات کاربری میتوانید وارد بخش مدیریت شوید و بعد از تایید مدارک ارسال شده میتوانید محصولات خود را اضافه نمایید
                            </p>
                        </v-alert>
                    </div>

                </v-card>

                <div style="margin-top:20px" v-if="showLoading">

                    <v-progress-circular
                        indeterminate
                        color="red"
                    ></v-progress-circular>

                    <span style="font-size:13px">در حال ارسال اطلاعات</span>
                </div>
            </div>
        </v-main>
    </div>
</template>

<script>
    export default {
        name: "Register",
        data(){
            return {
                step:1,
                server_error:false,
                mobile:'',
                showLoading:false,
                account_type:'',
                showDrawer:true
            }
        },
        mounted() {
            if(window.innerWidth<1000){
                this.showDrawer=false;
            }
            this.$root.$on('show_progress',()=>{
                this.server_error=false;
                this.showLoading=true;
            });

            this.$root.$on('hide_progress',(data)=>{
                 if(data!==undefined){
                     this.showLoading=false;
                     if(data.original!=null && data.original['status']!==undefined){
                         if(data.original['status']==='error'){
                             this.server_error=data.original['message'];
                         }
                         else if (data.original['status']==='ok'){
                             this.step=data.original['step'];
                             if(data.original['mobile']!==undefined){
                                 this.mobile=data.original['mobile'];
                             }
                             if(data.original['account_type']!==undefined){
                                 this.account_type=data.original['account_type'];
                             }
                             this.$root.$emit('seller_register_step'+this.step);
                         }
                         else if(data.original['status']==='error_file_type'){
                             this.server_error='فایل های انتخاب شده معتبر نمی باشند';
                         }
                     }
                 }
            });

            this.$root.$on('seller_register_next_step',()=>{
                this.step=this.step+1;
            });
        },
        methods:{
            nextStep:function (args) {
                this.step=this.step+1;
                this.server_error=false;
                if(this.mobile==='')
                {
                    this.mobile=(args.mobile===undefined) ? '' : args.mobile;
                }
                if(this.account_type==='')
                {
                    this.account_type=(args.account_type===undefined) ? '' : args.account_type;
                }
            }
        },
        props:['shop_name']
    }
</script>

<style>
    @import "../style.css";
</style>
