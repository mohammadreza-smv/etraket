<template>


    <v-card
        :disabled="disabled"
        :loading="loading"
        id="auth-box"
    >

        <slot name="before-forgot-form"/>

        <v-row v-if="error">
            <p style="color:red">{{ error }}</p>
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

                <div class="send_btn" @click="setMobileNumber()">
                    بازیابی کلمه عبور
                </div>

            </v-form>

        </div>

        <div v-else-if="step===2">

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

        <div v-else-if="step===3">

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

                <div class="send_btn" @click="changePassword()">
                    تغییر کلمه عبور
                </div>
            </v-form>

        </div>

    </v-card>

</template>

<script>
    import methods from "../methods";
    export default {
        name: "ForgotPassword",
        data(){
            return {
                loading:false,
                disabled:false,
                valid:false,
                mobile:'',
                mobileRules: {
                    required:v => !!v || 'لطفا شماره موبایل خود را وارد نمایید',
                },
                step:1,
                error:'',
                code:'',
                show_second:0,
                timeOut:null,
                h:'',
                m:'',
                s:'',
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
        mixins:[methods],
        mounted() {
            this.show_second=180;
            this.timeOut=setInterval(this.counter,1000);
        },
        methods:{
            changeForgetCode:function () {
                if (this.code.toString().length===6){
                    this.sendForgetCode();
                }
            }
        },
        beforeDestroy() {
            if(this.timeOut!==null) {
                clearInterval(this.timeOut);
            }
        }
    }
</script>


