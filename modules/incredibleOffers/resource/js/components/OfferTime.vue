<template>
    <div class="offer_box" v-if="show_second>0" style="align-items: center;border:0px">
        <img class="offer_pic" style="margin-top:20px" v-bind:src="this.$siteUrl+'/files/images/eccdcccd.png'">
        <div class="c-counter" style="display: flex;direction: ltr">
            <span>{{ h }}</span>:<span>{{ m }}</span>:<span>{{ s }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "OfferTime",
        data(){
            return{
                h:'',
                m:'',
                s:'',
                show_second:0,
                timer:null
            }
        },
        mounted(){
            this.show_second=this.second;
            this.counter();
            if(this.timer!=null){
                clearInterval(this.timer);
            }
            this.timer=setInterval(this.counter,1000);
        },
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
        },
        props:['second']
    }
</script>

