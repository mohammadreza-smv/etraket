<template>
    <div class="page_row">

        <div class="page_content" style='padding:0px 15px'>
            <slot name="message"></slot>
            <div class="shipping_data_box payment_box" style="padding:10px 10px 0px 10px;margin-top:0px">
                <v-radio-group v-model="radioGroup">
                    <slot name="paymentitems"></slot>
                </v-radio-group>
            </div>

            <slot name="content"></slot>

        </div>


        <div class="page_aside">
            <div class="order_info">

                <ul>
                    <slot name="factor"></slot>

                    <li v-for="item in factorItems">
                        <span>{{ item.label }}</span>
                        <span>{{ item.value }}</span>
                    </li>
                </ul>


                <v-divider></v-divider>

                <div class="checkout_content">
                    <p style="color:red">مبلغ قابل پرداخت : </p>
                    <p id="final_price">{{ price }}</p>
                </div>

                <v-btn class="send_btn" @click="sendFormData()">
                    <a style="color:white">
                        پرداخت و ثبت نهایی سفارش
                    </a>
                </v-btn>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "PaymentBox",
        props:['price','token'],
        data(){
            return {
                radioGroup:1,
                factorItems:[]
            }
        },
        methods:{
            sendFormData:function () {
                const form = document.createElement("form");
                form.setAttribute("method", "POST");
                form.setAttribute("action", this.$siteUrl+'/order/payment');
                form.setAttribute("target", "_self");

                const hiddenField = document.createElement("input");
                hiddenField.setAttribute("name", "_token");
                hiddenField.setAttribute("value", this.token);
                form.appendChild(hiddenField);

                const hiddenField2 = document.createElement("input");
                hiddenField2.setAttribute("name", "pay_type");
                hiddenField2.setAttribute("value", this.radioGroup);
                form.appendChild(hiddenField2);

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }
        },
        mounted() {
            this.$root.$on('add_factor_item',(payload)=>{
                let add=true;
                for (let i = 0; i <this.factorItems.length ; i++) {
                     if (this.factorItems[i]['name']===payload.name){
                         add=false;
                         this.factorItems[i]['label']=payload.label;
                         this.factorItems[i]['value']=payload.value;
                     }
                }
                if(add){
                    this.factorItems.push(payload);
                }
            });
        }
    }
</script>
