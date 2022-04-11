<template>

    <div  id="auth-box">

        <v-card
            :disabled="disabled"
            :loading="loading"
        >
            <slot name="before-register-form"/>

            <v-row v-if="serverError" >
                <v-alert type="error">{{ serverError }}</v-alert>
            </v-row>

            <v-row v-if="validateError.length>0" >
                <v-alert type="warning">
                    <ul>
                        <li v-for="e in validateError" style="list-style:none">
                            {{ e }}
                        </li>
                    </ul>
                </v-alert>
            </v-row>

            <div v-if="step===1">


                <v-form v-model="valid" ref="form">

                    <v-row>

                        <v-text-field
                            label="شماره موبایل"
                            outlined
                            v-model="mobile"
                            :rules="[mobileRules.required,checkMobileNumber]"
                        ></v-text-field>

                    </v-row>

                    <v-row>

                        <v-text-field
                            label="کلمه عبور"
                            outlined
                            v-model="password"
                            :rules="passwordRules"
                            type="password"
                        ></v-text-field>

                    </v-row>

                    <v-row>
                        <a class="router-link reset_password_link" href="">بازیابی کلمه عبور</a>
                    </v-row>



                    <div class="send_btn" @click="register()">
                        ثبت نام در فروشگاه
                    </div>

                    <v-row  style="margin:20px 0px">

                        <p style="font-size:13px">
                            با  ثبت نام در {{ shop_name }} شما
                            <a class="help-link"> شرایط و قوانین</a>
                            استفاده از سرویس های سایت {{ shop_name }}
                            و
                            <a class="help-link">قوانین حریم خصوصی</a>
                            آن را می‌پذیرید.
                        </p>

                    </v-row>

                </v-form>

                <v-alert class="alert-register">
                    <span>قبلا در سایت ثبت نام کرده اید ؟</span>
                    <span>
                 <a class="router-link data_link" :href="$siteUrl+'/login'">وارد شوید</a>
            </span>
                </v-alert>
            </div>

            <div v-else>


                <v-row>

                    <v-alert type="success">
                        <span>به شماره موبایل {{ replaceNumber(mobile) }} کد تایید ارسال شد</span>
                        <a @click="showRegisterForm()" class="help-link" style="margin-right:10px">ویرایش شماره</a>
                    </v-alert>

                </v-row>

                <v-row>

                    <v-text-field
                        class="active-code"
                        autofocus
                        outlined
                        @input="changeActiveCode"
                        v-model="activeCode"
                    >

                    </v-text-field>

                </v-row>

                <v-row>

                    <div id="resend_active_code" style="display: flex;padding-bottom:20px">
                        <span @click="resend_active_code()" style="cursor:pointer;font-weight:bold;">ارسال مجدد کد</span>

                        <div class="c-counter" style="padding-right:10px" v-if="show_second>0">
                           <span>{{ h }}</span>:<span>{{ m }}</span>:<span>{{ s }}</span>
                        </div>
                    </div>

                </v-row>

            </div>



        </v-card>

        <v-snackbar
            v-model="snackbar"
            timeout="1000"
        >
            کد فعال سازی جدید ارسال شد

        </v-snackbar>

    </div>

</template>

<script>
    import methods from "../methods";

    export default {
        name: "AuthLoginBox",
        mixins:[methods],
        data(){
            return {
                loading:false,
                disabled:false,
                valid:false,
                mobile:'',
                mobileRules: {
                    required:v => !!v || 'لطفا شماره موبایل خود را وارد نمایید',
                },
                password:'',
                passwordRules:[
                    v => !!v || 'لطفا کلمه عبور خود را وارد نمایید',
                ],
                remember:false,
                serverError:false,
                validateError:[],
                usernameRules:[
                    v => !!v || 'لطفا نام کاربری خود را وارد نمایید',
                ],
                username:'',
                step:1,
                activeCode:'',
                h:'',
                m:'',
                s:'',
                show_second:0,
                timeOut:null,
                snackbar:null
            }
        },
        props:['shop_name'],
        methods:{
            showRegisterForm:function () {
                this.step=1;
                if(this.timeOut!==null){
                    clearInterval(this.timeOut);
                }
            }
        }
    }
</script>

<style scoped>
    @import "../../assets/auth.css";
</style>
