<template>
    <v-card :loading="sendRequest" :disabled="sendRequest">
       <v-card-title>
           <h4 style="color: black">استفاده از کد تخفیف {{ siteName }}</h4>
       </v-card-title>
       <v-card-text>
           <p style="padding:10px 0px">با ثبت کد تخفیف،مبلغ کد تخفیف از مبلغ قابل پرداخت کسر میشود.</p>
           <div style="display: flex">
               <v-text-field
                   label="کد تخفیف"
                   outlined
                   v-model="code"
                   class="discount-input"
               ></v-text-field>
               <v-btn @click="send_code()" class="discount-btn" color="success">
                   ثبت کد تخفیف
               </v-btn>
           </div>

           <v-alert v-if="success_message" type="success">
               {{ success_message }}
           </v-alert>

           <v-alert v-if="error_message" type="error">
               {{ error_message }}
           </v-alert>
       </v-card-text>

    </v-card>
</template>

<script>
    import methods from "./methods";
    export default {
        name: "DiscountBox",
        props:['order_price','siteName'],
        mixins:[methods],
        data(){
            return {
                code:'',
                error_message:false,
                success_message:false,
                sendRequest:false
            }
        },
        methods:{
            send_code:function () {
                if(this.code.trim()!==""){
                    this.success_message='';
                    this.sendRequest=true;
                    this.error_message='';
                    const url=this.$siteUrl+'/site/check_discount_code';
                    const formData=new FormData();
                    formData.append('code',this.code);
                    this.axios.post(url,formData).then(response=>{
                        this.sendRequest=false;
                        if(response.data.status==='ok')
                        {
                            document.querySelector('.checkout_discount').style.display='none';
                            this.code='';
                            this.success_message='کد تخفیف وارد شده صحیح می باشد و مبلغ تخفیف از هزینه کسر شد';
                            this.error_message=false;
                            const data={};
                            data.label='تخفیف';
                            data.value=this.replaceNumber(this.number_format(response.data['discount_value']))+' تومان';
                            data.type='minus';
                            data.name='discount';
                            this.$root.$emit('add_factor_item',data);
                            let p=(this.order_price-response.data['discount_value']);
                            p=this.replaceNumber(this.number_format(p))+' تومان';
                            document.querySelector('#final_price').innerHTML=p;
                        }
                        else {
                            this.success_message=false;
                            this.error_message=response.data.message;
                        }
                    }).catch(error=>{
                        this.sendRequest=false;
                        this.error_message='خطا در ارسال اطلاعات،مجددا تلاش نمایید';
                    });
                }
                else{
                    this.error_message='لطفا کد تخفیف را وارد نمایید';
                }
            }
        }
    }
</script>

<style>
@import "./style.css";
</style>
