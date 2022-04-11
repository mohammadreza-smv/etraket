<template>
    <div class="shipping_data_box">
        <p class="shipping_data_box_title">استفاده از کارت هدیه {{ $siteName }}</p>
        <p>با ثبت کارت هدیه،مبلغ کارت هدیه از مبلغ قابل پرداخت کسر میشود.</p>

        <div class="form-group" style="display: flex">
            <input type="text" v-model="code" class="form-control discount_input">
            <button v-on:click="send_code()" class="btn btn-success discount_btn">ثبت کارت هدیه</button>
        </div>

        <div v-if="success_message" class="alert alert-success">
            {{ success_message }}
        </div>

        <div v-if="error_message" class="alert alert-danger">
            {{ error_message }}
        </div>
    </div>
</template>

<script>
    export default {
        name: "GiftCart",
        data(){
            return {
                code:'',
                error_message:false,
                success_message:false
            }
        },
        methods:{
            send_code:function () {
                if(this.code.trim()!=""){
                    $("#loading_box").show();
                    const url=this.$siteUrl+'/site/check_gift_cart';
                    const formData=new FormData();
                    formData.append('code',this.code);
                    this.axios.post(url,formData).then(response=>{
                        $("#loading_box").hide();
                        if(response.data.status=='ok')
                        {
                            this.code='';
                            const gift_value=response.data.gift_value;
                            const cart_final_price=response.data.cart_final_price;
                            $('.gift_li').show();
                            $("#gift_cart_amout").text(gift_value);
                            $("#final_price").text(cart_final_price);
                            this.error_message=false;
                            this.success_message='کارت هدیه وارد شده صحیح می باشد و مبلغ کارت هدیه از هزینه کسر شد';
                        }
                        else {
                            this.success_message=false;
                            this.error_message=response.data;
                        }
                    }).catch(error=>{
                        $("#loading_box").hide();
                        this.error_message='خطا در ارسال اطلاعات،مجددا تلاش نمایید';
                    });
                }
                else{
                    this.error_message='لطفا کد کارت هدیه را وارد نمایید';
                }
            }
        }
    }
</script>

<style scoped>

</style>
