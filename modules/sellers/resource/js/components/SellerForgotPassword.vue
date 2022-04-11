<template>
    <div>
        <v-navigation-drawer
            width="300"
            app
            permanent
            right
            class="right_box"
            v-if="showDrawer"
        >
            <div class="login_right_box">
                <slot name="login-right-box"></slot>
            </div>
        </v-navigation-drawer>

        <v-main>

            <div class="register_form_box" style="flex-direction: column;">

                <v-row v-if="error">
                    <p style="color:red">{{ error }}</p>
                </v-row>

                <div v-if="step===1" style="min-width:400px" class="auth-box-row">
                    <v-form v-model="valid" ref="form">

                        <v-row>

                            <v-text-field
                                label="شماره موبایل"
                                outlined
                                v-model="mobile"
                                :rules="[mobileRules.required,checkMobileNumber]"
                            ></v-text-field>

                        </v-row>

                        <v-btn color="success" @click="setMobileNumber()">
                            بازیابی کلمه عبور
                        </v-btn>

                    </v-form>
                </div>

                <div v-else-if="step===2" class="auth-box-row">

                    <v-row>

                        <v-alert color="success">
                            <span style="color: white">کد تایید ارسال شده به شماره موبایل {{ replaceNumber(mobile) }} را وارد کنید</span>
                        </v-alert>

                    </v-row>

                    <v-row>

                        <v-text-field
                            class="active-code"
                            autofocus
                            outlined
                            @input="changeForgetCode"
                            v-model="code"
                        >

                        </v-text-field>

                    </v-row>

                    <v-row>

                        <div id="resend_active_code" style="display: flex;padding-bottom:20px">
                            <span @click="resend_active_code('forget_password')" style="cursor:pointer;font-weight:bold;">ارسال مجدد کد</span>

                            <div class="c-counter" style="padding-right:10px" v-if="show_second>0">
                                <span>{{ h }}</span>:<span>{{ m }}</span>:<span>{{ s }}</span>
                            </div>
                        </div>

                    </v-row>

                </div>

                <div v-else-if="step===3" class="auth-box-row">

                    <v-form v-model="valid" ref="form2">

                        <v-row>

                            <v-text-field
                                label="کلمه عبور"
                                outlined
                                type="password"
                                v-model="password1"
                                :rules="password1Rules"
                            ></v-text-field>

                        </v-row>

                        <v-row>

                            <v-text-field
                                label="تکرار کلمه عبور"
                                outlined
                                type="password"
                                v-model="password2"
                                :rules="[password2Rules.required,confirmationPassword]"
                            ></v-text-field>

                        </v-row>

                        <v-btn color="error" @click="changePassword()">
                            تغییر کلمه عبور
                        </v-btn>
                    </v-form>

                </div>

                <div style="margin-top:20px" v-if="loading">

                    <v-progress-circular
                        indeterminate
                        color="red"
                    ></v-progress-circular>

                    <span style="font-size:13px">در حال ارسال اطلاعات</span>
                </div>

                <div style="margin-top:20px">
                    <slot name="content"></slot>
                </div>

            </div>
        </v-main>
    </div>
</template>

<script>
import methods from '../methods';
export default {
    name: "SellerForgotPassword",
    mixins:[methods],
    data(){
        return {
            showDrawer:true,
            step:1,
            error:'',
            code:'',
            show_second:0,
            timeOut:null,
            h:'',
            m:'',
            s:'',
            loading:false,
            disabled:false,
            valid:false,
            mobile:'',
            mobileRules: {
                required:v => !!v || 'لطفا شماره موبایل خود را وارد نمایید',
            },
            resend:true,
            token:'',
            password1:'',
            password2:'',
            password1Rules: [
                v => !!v || 'لطفا کلمه عبور را وارد نمایید',
                v => v.length >= 6 || 'کلمه عبور باید حداقل شامل ۶ کاراکتر باشد',
            ],
            password2Rules: {
                required:v => !!v || 'لطفا تکرار کلمه عبور را وارد نمایید',
            },
        }
    },
    methods:{
        changeForgetCode:function () {
            if (this.code.toString().length===6){
                this.sendForgetCode();
            }
        }
    },
    mounted() {
        if(window.innerWidth<1000){
            this.showDrawer=false;
        }
    }
}
</script>
<style>
@import "../style.css";
</style>

