<template>
    <div class="product_offer_div"  v-if="check_has_off(product)">
        <div>
            <div class="product_offer_box" v-if="show_second>0">
                <img class="offer_pic" v-bind:src="this.$siteUrl+'/files/images/eccdcccd.png'">
                <div class="c-counter" style="display: flex;direction: ltr">
                    <span>{{ h }}</span>:<span>{{ m }}</span>:<span>{{ s }}</span>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <div v-if="show==='vertical'" class="product_offer_div"></div>
    </div>

</template>

<script>
    export default {
        name: "ProductOffersTime",
        data(){
            return{
                h:'',
                m:'',
                s:'',
                show_second:0,
                timer:null
            }
        },
        props:['product','show'],
        methods:{
            counter:function () {
                let second=this.show_second;
                let h=Math.floor(second/3600);
                second=second-h*3600;
                let m=Math.floor(second/60);
                let s=second-m*60;
                if(h.toString().length==1)
                {
                    h="0"+h;
                }
                if(m.toString().length==1)
                {
                    m="0"+m;
                }
                if(s.toString().length==1)
                {
                    s="0"+s;
                }
                this.h=this.replaceNumber(h);
                this.m=this.replaceNumber(m);
                this.s=this.replaceNumber(s);
                this.show_second=this.show_second-1;
            },
            replaceNumber:function (n) {
                n=n.toString();
                const find=["0","1","2","3","4","5","6","7","8","9"];
                const replace=["۰","۱","۲","۳","۴","۵","۶","۷","۸","۹"];
                for (let i=0;i<find.length;i++)
                {
                    n=n.replace(new RegExp(find[i],'g'),replace[i]);
                }
                return n;
            },
            check_has_off:function (product) {
                if(product.first_product_price!=null)
                {
                    const last_time=product.first_product_price.offers_last_time;
                    const time=Math.floor(Date.now()/1000);
                    if(product.first_product_price.offers==1 && (last_time-time)>0)
                    {
                        this.show_second=(last_time-time);
                        return true;
                    }
                    else {
                        return  false;
                    }
                }
                else{
                    return  false;
                }
            },
        },
        mounted() {
            this.$nextTick(function () {
                this.counter();
                this.timer=setInterval(this.counter,1000);
            });
        }
    }
</script>

<style>
    @import "../style.css";
</style>
