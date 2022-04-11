<template>
    <div>

        <div>
            <v-btn
                class="notification-btn"
                @click="showDialogBox()"
                v-if="send_status_notification==='no'"
            >
                <v-icon>mdi-bell-ring</v-icon>
                موجود شد اطلاع بده
            </v-btn>

            <v-btn
                class="notification-btn"
                v-else
                @click="removeRequest"
            >
                <v-icon>mdi-bell-ring</v-icon>
                دیگه لازم نیست اطلاع بدی
            </v-btn>
        </div>

        <v-dialog
           v-model="dialog"
           width="550"
        >
            <v-card>
                <v-card-title class="headline lighten-2 notification-box-header">
                    <h5>به من اطلاع بده</h5>
                    <v-icon @click="dialog=false">mdi-close</v-icon>

                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="4" class="notification-icon-box">
                            <v-icon size="50">mdi-bell-ring</v-icon>
                        </v-col>
                        <v-col cols="8" >
                            <h4>اطلاع به من در زمان:
                                <span style="color: black">موجود شدن</span>
                            </h4>
                            <v-divider style="margin-top:10px;margin-bottom:10px"></v-divider>

                            <span style="font-size:17px">از طریق:</span>

                            <v-checkbox
                                label="سیستم پیام شخصی "
                                hide-details
                                v-model="send_message"
                            ></v-checkbox>
                            <v-checkbox
                                :label="'پیامک به '+replaceNumber(mobile)"
                                hide-details
                                v-model="send_sms"
                            ></v-checkbox>

                            <v-btn
                                color="primary"
                                style="margin-top:25px"
                                @click="sendRequest()"
                            >
                                ثبت
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog
            v-model="responseDialog"
            width="500"
        >

            <v-card>

                <v-card-text >

                    <div class="server-response">

                        <v-icon color="green" size="25" v-if="responseType==='success'">mdi-check</v-icon>
                        <v-icon color="reed" size="25" v-if="responseType==='error'">mdi-alert</v-icon>
                        <span> {{ responseMessage }} </span>

                    </div>

                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        text
                        @click="responseDialog = false"
                    >
                        بستن
                    </v-btn>
                </v-card-actions>
            </v-card>

        </v-dialog>

    </div>
</template>

<script>
export default {
    props:['auth','themeType','send_status_notification','mobile','product_id'],
    name: "NotificationBtn",
    data(){
       return {
           responseDialog:false,
           dialog:false,
           send_message:false,
           send_sms:false,
           responseType:'error',
           responseMessage:'خطا در اجرای درخواست مجددا تلاش نمایید'
       }
    },
    methods:{
        showDialogBox:function (){
             if(this.auth==='no'){
                 this.$root.$emit('show_'+this.themeType+'_login');
             }
             else {
                 this.dialog=true;
             }
        },
        replaceNumber: function (n) {
            if (n != undefined) {
                n = n.toString();
                const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                for (let i = 0; i < find.length; i++) {
                    n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                }
                return n;
            }
        },
        sendRequest:function (){
            if(this.send_message || this.send_sms){
                this.dialog=false;
                this.$root.$emit('show_progress');
                const url=this.$siteUrl+'/product/notification-status/add/notification';
                this.axios.post(url,{
                    product_id:this.product_id,
                    send_message:this.send_message,
                    send_sms:this.send_sms
                }).then(response=>{
                    this.$root.$emit('hide_progress');
                    if(response.data.status==='success'){
                        this.send_status_notification='yes';
                    }
                    this.responseDialog=true;
                    this.responseMessage=response.data['message'];
                    this.responseType=response.data['status'];
                }).catch(error=>{
                    this.$root.$emit('hide_progress');
                    this.responseMessage='خطا در اجرای درخواست ، مجددا تلاش نمایید';
                    this.responseDialog=true;
                });
            }
        },
        removeRequest:function (){
            if(this.send_status_notification==='yes'){
                this.$root.$emit('show_progress');
                const url=this.$siteUrl+'/product/notification-status/remove-request';
                this.axios.post(url,{
                    product_id:this.product_id
                }).then(response=>{
                    this.$root.$emit('hide_progress');
                    this.send_status_notification='no';
                }).catch(error=>{
                    this.$root.$emit('hide_progress');
                });
            }
        }
    }
}
</script>

<style>
@import "../style.css";
</style>
