<template>
    <div>
        <div class="shipping_data_box" style="padding-right: 0px;padding-left:0px">

            <div class="submission_send_type" v-if="cartData.send_methods!=null">
                <div style="display: flex">
                    <img v-bind:src="$siteUrl+'/files/upload/'+cartData.send_methods[type_key].icon">
                    <span style="padding:5px">{{ cartData.send_methods[type_key].title }}</span>
                </div>
            </div>

            <div class="swiper_product_box">
                <v-slide-group
                    multiple
                    show-arrows
                >
                    <v-slide-item v-for="(index,key) in data" :key="key" class="product_info_box">
                        <div>
                            <img v-bind:src="$siteUrl+'/files/thumbnails/'+cartData['products'][1][index].product.image_url">
                            <p>{{ cartData['products'][1][index].product.title }}</p>

                            <p v-for="(array,key) in cartData['products'][1][index].price_params" class="product_color_name">
                                   <span v-if="array['title']!=undefined">
                                         {{ array['title'] }} :
                                   </span>

                                  <span>{{ array['value'] }}</span>
                            </p>

                        </div>
                    </v-slide-item>
                </v-slide-group>
            </div>
            <div v-if="cartData.send_methods!=null">
                <img class="checkout_image" v-bind:src="$siteUrl+'/files/upload/'+cartData.send_methods[type_key].icon">
                <div class="checkout_time">
                    <p>
                        <span>بازه تحویل سفارش:</span>
                        <span>زمان تقریبی تحویل از</span>
                        <span>{{ submission_info.sending_order_day.day_label1 }}</span>
                        <span>تا</span>
                        <span>{{ submission_info.sending_order_day.day_label2 }}</span>
                    </p>
                     <span>شیوه ارسال : </span>
                     <span class="bold">{{ cartData.send_methods[type_key].send_type_name  }}</span>
                     <span>هزینه ارسال:</span>
                     <span class="bold" v-if="submission_info.price_type===0">
                         {{ getPrice(submission_info.sending_price) }}
                     </span>
                     <span v-else>
                       متغیر (پس کرایه)،حداقل هزینه ارسال :  {{ getPrice(submission_info.sending_price) }}
                     </span>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import cartEvent from "../../cartEvent";
    export default {
        name: "SubmissionProduct",
        mixins:[cartEvent],
        props:['data','type_key','submission_info'],
        computed:{
            cartData:function () {
                return this.$store.state.OrdersStore.cartData;
            },
            send_type:function () {
                return this.$store.state.OrdersStore.send_type;
            }
        }
    }
</script>


