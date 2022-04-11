<template>
    <div id="send_order_type_box">





        <div v-if="normal_send">

            <div v-for="(item,key,index) in OrderingData.cart_product_data">
                <p>
                    <span>مرسوله</span>
                    <span>{{ replaceNumber(i=index+1) }}</span>
                    <span>از</span>
                    <span>{{ replaceNumber(Object.keys(OrderingData.cart_product_data).length) }}</span>
                </p>
                <div class="shipping_data_box" style="padding-right: 0px;padding-left:0px">
                    <div class="submission_send_type">
                        <div>
                            <img v-bind:src="$siteUrl+'/files/upload/'+OrderingData.submission_type[key].icon">
                            <span>{{ OrderingData.submission_type[key].label }}</span>
                        </div>
                    </div>
                    <div class="swiper_product_box">

                        <swiper :options="swiperOption">
                            <swiper-slide v-for="product in item" v-if="product.product_count" :key="product.product_id"   class="product_info_box">
                                <img v-bind:src="$siteUrl+'/files/thumbnails/'+product.product_image_url">
                                <p>{{ product.product_title }}</p>
                                <p class="product_color_name" v-if="product.color_id>0">
                                    <span v-if="product.color_type==1">رنگ : </span>
                                    <span v-else>سایز : </span>
                                    {{ product.color_name }}</p>
                                <p class="product_color_name">فروشنده : {{ product.seller_name }}</p>
                            </swiper-slide>

                            <div class="swiper-button-next" slot="button-next"></div>
                            <div class="swiper-button-prev" slot="button-prev"></div>
                        </swiper>

                    </div>

                    <div>
                        <img class="checkout_image" v-bind:src="$siteUrl+'/files/upload/'+OrderingData.submission_type[key].icon" />
                        <div class="checkout_time">
                            <p>
                                <span>بازه تحویل سفارش:</span>
                                <span>زمان تقریبی تحویل از</span>
                                <span>{{ OrderingData.min_ordering_day[key] }}</span>
                                <span>تا</span>
                                <span>{{ OrderingData.max_ordering_day[key] }}</span>
                            </p>
                            <span>شیوه ارسال : </span>
                            <span class="bold">{{ OrderingData.submission_type[key].send_type_name }}</span>
                            <span>هزینه ارسال:</span>
                            <span class="bold">{{ get_send_price(OrderingData.send_price_type[key],OrderingData.normal_send_order_amount[key],key) }}</span>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div  v-if="fast_send" v-for="(delivery_order_interval,key) in OrderingData.delivery_order_interval">

            <p>
                <span>مرسوله</span>
                <span>{{ replaceNumber(i=key+1) }}</span>
                <span>از</span>
                <span>{{ replaceNumber(OrderingData.delivery_order_interval.length) }}</span>
            </p>

            <div class="shipping_data_box" style="padding-right: 0px;padding-left:0px">

                <div class="swiper_product_box">
                    <swiper :options="swiperOption">
                        <swiper-slide v-for="(data,key2) in OrderingData.array_product_id[delivery_order_interval.send_type][delivery_order_interval.send_type_key]" :key="key" v-if="OrderingData.cart_product_data[delivery_order_interval.send_type][data+'_'+key2].product_count>0"  class="product_info_box">
                            <img v-bind:src="$siteUrl+'/files/thumbnails/'+OrderingData.cart_product_data[delivery_order_interval.send_type][data+'_'+key2].product_image_url">
                            <p>{{ OrderingData.cart_product_data[delivery_order_interval.send_type][data+'_'+key2].product_title }}</p>
                            <p class="product_color_name" v-if="OrderingData.cart_product_data[delivery_order_interval.send_type][data+'_'+key2].color_id>0">
                                <span v-if="OrderingData.cart_product_data[delivery_order_interval.send_type][data+'_'+key2].color_type==1">رنگ :</span>
                                <span v-else>سایز :</span>
                                {{ OrderingData.cart_product_data[delivery_order_interval.send_type][data+'_'+key2].color_name }}</p>
                            <p class="product_color_name">فروشنده : {{ OrderingData.cart_product_data[delivery_order_interval.send_type][data+'_'+key2].seller_name }}</p>
                        </swiper-slide>


                        <div class="swiper-button-next" slot="button-next"></div>
                        <div class="swiper-button-prev" slot="button-prev"></div>
                    </swiper>
                </div>

                <div>
                    <img class="checkout_image" v-bind:src="$siteUrl+'/files/upload/'+OrderingData.submission_type[delivery_order_interval.send_type].icon">

                    <div class="checkout_time">
                        <p>
                            <span>بازه تحویل سفارش:</span>
                            <span>زمان تقریبی تحویل از</span>
                            <span>{{ delivery_order_interval.day_label1 }}</span>
                            <span>تا</span>
                            <span>{{ delivery_order_interval.day_label2 }}</span>
                        </p>
                        <span>شیوه ارسال : </span>
                        <span class="bold">{{ OrderingData.submission_type[delivery_order_interval.send_type].send_type_name }}</span>
                        <span>هزینه ارسال:</span>
                        <span class="bold">{{ get_send_price(OrderingData.send_price_type[delivery_order_interval.send_type],delivery_order_interval.send_fast_price,delivery_order_interval.send_type) }}</span>

                    </div>
                </div>

            </div>
        </div>



    </div>
</template>

<script>
    import myMixin from "../myMixin";
    import { swiper, swiperSlide } from 'vue-awesome-swiper';
   // import 'swiper/dist/css/swiper.css'
    export default {
        name: "OrderingTime",
        props:['city_id','mobile'],
        mixins:[myMixin],
        components:{swiper,swiperSlide},
        data(){
            return {
                has_changes_cart:false
            }
        },
        mounted(){
            this.checkout_action= this.mobile=='ok' ? false: true;
            this.get_ordering_time();
        },
        methods:{
            get_ordering_time:function () {
                this.axios.get(this.$siteUrl+"/shipping/getSendData/"+this.city_id).then(response=>{
                    this.OrderingData=response.data;
                    if(this.OrderingData.delivery_order_interval.length!=Object.keys(this.OrderingData.cart_product_data).length)
                    {
                        this.multi_type_send=true;
                    }
                    this.setPrice();
                    this.check_changes_cart();
                });
            },
            send_normal_send:function () {
                this.normal_send=true;
                this.fast_send=false;
                this.setPrice();
                document.getElementById('send_type').value=1;
            },
            send_fast_send:function () {
                this.normal_send=false;
                this.fast_send=true;
                document.getElementById('send_type').value=2;
                this.setPrice();
            },
            setPrice:function () {
                if(this.normal_send)
                {
                    const send_price=this.get_send_order_amount(this.OrderingData.normal_send_order_amount)
                    $("#total_send_order_price").text(send_price);
                    $("#final_price").text(this.OrderingData.normal_cart_price);
                }
                else{
                    const send_price=this.get_send_order_amount(this.OrderingData.total_fast_send_amount)
                    $("#total_send_order_price").text(send_price);
                    $("#final_price").text(this.OrderingData.fasted_cart_amount);
                }
            },
            check_changes_cart:function(){
                const app=this;
                for (var key in  this.OrderingData.cart_product_data) {
                    const row=this.OrderingData.cart_product_data[key];
                    if(row.initial_amount!=undefined)
                    {
                        if(row.initial_amount!=(row.price2/row.product_count)){
                            app.has_changes_cart=true;
                        }
                    }
                }
                if(app.has_changes_cart){
                    app.$emit('change_cart_status');
                }
            },
            get_send_order_amount:function(arrayData){
                const keys=Object.keys(arrayData);
                let result=0;
                let otherPrice=false;
                for (let i=0;i<keys.length;i++){
                    if(this.OrderingData.send_price_type[keys[i]]==0){
                        result+=arrayData[keys[i]];
                    }
                    else{
                        otherPrice=true;
                    }
                }
                if(result>0){
                    result=this.getPrice(result);
                }
                if(otherPrice){
                    result=result+" + پس کرایه ";
                }

                if(result==0){
                    result="رایگان"
                }
                return result;
            }
        },
        watch:{
            city_id:function (newVal,oldVal) {
               this.city_id=newVal;
                this.get_ordering_time();
            }
        }
    }
</script>

<style scoped>

</style>
