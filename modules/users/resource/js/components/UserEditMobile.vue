<template>
    <v-dialog
        v-model="dialog"
        width="450"
    >
        <v-card :loading="loading" :disabled="loading">
            <v-card-title style="font-size:16px">
                <v-btn
                    icon
                    @click="dialog = false"
                >
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                شماره موبایل
            </v-card-title>

            <v-card-text style="padding-top:20px">

                <v-form   ref="form" v-model="valid">

                    <v-alert type="error" v-if="serverError">
                        {{ serverError }}
                    </v-alert>

                    <v-text-field
                        outlined
                        label="شماره موبایل"
                        v-model="mobile"
                        :rules="[mobileRules.required,checkMobileNumber]"
                        v-if="step===1"
                    ></v-text-field>

                    <div v-else-if="step===2">

                        <v-row>

                            <v-alert type="success" style="width:100%">
                                <span>به شماره موبایل {{ replaceNumber(mobile) }} کد تایید ارسال شد</span>
                            </v-alert>

                        </v-row>

                        <v-row>

                            <v-text-field
                                class="active-code"
                                autofocus
                                outlined
                                v-model="activeCode"
                                label="کد تایید"
                                @input="changeActiveCode2"
                            >

                            </v-text-field>

                        </v-row>

                        <v-row>

                            <div id="resend_active_code" style="display: flex;">
                                <span @click="resend_active_code()" style="cursor:pointer;font-weight:bold;">ارسال مجدد کد</span>

                                <div class="c-counter" style="padding-right:10px" v-if="show_second>0">
                                    <span>{{ h }}</span>:<span>{{ m }}</span>:<span>{{ s }}</span>
                                </div>
                            </div>

                        </v-row>

                    </div>

                </v-form>


            </v-card-text>


            <v-card-actions v-if="step===1">
                <v-spacer></v-spacer>
                <v-btn
                    color="success"
                    @click="updateMobileNumber()"
                >
                    ثبت
                </v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>
</template>

<script>
    import methods from "../methods";
    export default {
        name: "UserEditMobile",
        mixins:[methods],
        data(){
            return {
                mobile:'',
                dialog:false,
                valid:false,
                loading:false,
                serverError:false,
                mobileRules: {
                    required:v => !!v || 'لطفا شماره موبایل خود را وارد نمایید',
                },
                step:1,
                activeCode:'',
                h:'',
                m:'',
                s:'',
                show_second:0,
                timeOut:null,
            }
        },
        mounted() {
            this.$root.$on('edit_user_mobile',(value)=>{
                if(value!=='-'){
                    this.mobile=value;
                    this.step=1;
                }
                this.dialog=true;
            });
        },
        methods:{
            updateMobileNumber:function () {
                this.$refs.form.validate();
                if(this.valid){
                    this.loading=true;
                    this.serverError=false;
                    const formData=new FormData();
                    formData.append('mobile',this.mobile);
                    const url=this.$siteUrl+'/user/mobile/update';
                    this.axios.post(url,formData).then(response=>{
                        this.loading=false;
                        if(response.data==='ok'){
                            this.step=2;
                            this.show_second=180;
                            this.timeOut=setInterval(this.counter,1000);
                        }
                        else{
                            this.serverError=response.data;
                        }
                    }).catch(error=>{
                        this.loading=false;
                        this.serverError='خطا در ارسال اطلاعات،مجددا تلاش نمایید';
                    });
                }
            }
        }
    }
</script>


