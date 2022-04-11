<template>
    <div>
        <v-card v-if="list.length>1" class="product_item_box">
            <v-card-title style="display:flex;justify-content: space-between;align-items: center">
                <span @click="showBox">
                    {{ replaceNumber((list.length-1))}}
                    فروشنده دیگر این کالا
                </span>
                <v-icon @click="showBox">mdi-chevron-left</v-icon>
            </v-card-title>
        </v-card>

        <v-navigation-drawer
            v-model="drawer"
            fixed
            right
            width="100%"
        >

            <v-toolbar
                elevation="0"
            >
                <div class="other-variation-page-header">
                    <span>لیست فروشندگان این کالا</span>
                    <div v-on:click="drawer=!drawer">
                        <span>بازگشت</span>
                        <v-icon @click="showBox">mdi-chevron-left</v-icon>
                    </div>
                </div>
            </v-toolbar>

            <div style="padding-top: 10px"></div>

            <div class="productPriceList">

                <div :class="[key===0 ? 'variation_list active' : 'variation_list']" v-for="(variation,key) in list">

                    <slot name="variation-list-detail" :variation="variation"></slot>

                    <div class="variation-item">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                        <span
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon>mdi-calendar-today</v-icon>
                            {{ get_day(variation.send_time) }}
                        </span>
                            </template>
                            <span>{{  get_time_message(variation.send_time) }}</span>
                        </v-tooltip>
                    </div>

                    <v-divider></v-divider>

                    <div class="variation-action-box">
                        <span class="price">
                            {{ replaceNumber(number_format(variation.price2)) }} تومان
                        </span>

                        <a class="btn-seller-add-cart2" v-on:click="add_product(variation)">
                            افزودن به سبد خرید
                        </a>
                    </div>
                </div>

            </div>

        </v-navigation-drawer>
    </div>
</template>

<script>
export default {
    name: "MobileOtherPriceVariation",
    props:['product_id'],
    data(){
         return {
             list:[],
             request_count:0,
             param1_id:null,
             drawer:false
         }
    },
    mounted() {
        const el=document.querySelector("[data-param-key='1']");
        if(el!==null){
            this.param1_id=el.getAttribute('data-param-id');
        }
        this.$root.$on('update_variation',(elId)=>{
            const el=document.getElementById(elId);
            if(el){
                this.param1_id=el.getAttribute('data-param-id');
                this.request_count=0;
                this.getVariationList();
            }
        });
        this.getVariationList();
    },
    methods:{
        getVariationList:function(){
            this.request_count=this.request_count+1;
            const url=this.$siteUrl+"/api/variation/product/"+this.product_id;
            const formData=new FormData();
            formData.append('param1_id',this.param1_id);
            this.axios.post(url,formData).then(response=>{
                this.request_count=0;
                this.list=response.data.original;
            }).catch(error=>{
                if(this.request_count<2)
                {
                    this.getVariationList();
                }
            });
        },
        get_day:function (day) {
            if(day===0)
            {
                return 'آماده ارسال';
            }
            else {
                return  'ارسال از '+this.replaceNumber(day)+' روز کاری آینده';
            }
        },
        replaceNumber: function (n) {
            if (n !==undefined) {
                n = n.toString();
                const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                for (let i = 0; i < find.length; i++) {
                    n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                }
                return n;
            }
        },
        get_time_message:function (day) {
            if(day===0)
            {
                return 'این کالا در حال حاضر در انبار دیجی آنلاین موجود ، آماده پردازش و ارسال است';
            }
            else {
                return 'این کالا در انبار فروشنده موجود است، برای ارسال باید برای مدت زمان ذکر شده منتظر بمانید.';
            }
        },
        add_product:function (variation){
            this.drawer=false;
            document.getElementById('variation_param1').value=variation.param1_id;
            document.getElementById('variation_param2').value=variation.param2_id;
            this.$root.$emit('add_card_product');
        },
        showBox:function (){
            this.drawer=!this.drawer
        },
        number_format: function (num) {
            num = num.toString();
            let format = '';
            let counter = 0;
            for (let i = num.length - 1; i >= 0; i--) {
                format += num[i];
                counter++;
                if (counter === 3) {
                    format += ",";
                    counter = 0;
                }
            }
            return format.split('').reverse().join('');
        },
    }
}
</script>

<style scoped>
@import "../../assets/style.css";
</style>
