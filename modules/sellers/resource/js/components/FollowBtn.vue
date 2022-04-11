<template>
    <div style="width:100%;text-align: center;padding:10px">

        <ul style="margin-bottom: 30px" class="seller-info-ul">
            <li>
                <span>آخرین فعالیت فروشنده</span>
                <span>{{ lastDate }}</span>
            </li>
            <li>
                <span>تعداد دنبال کنندگان</span>
                <span>{{ replaceNumber(count) }}</span>
            </li>
        </ul>

        <v-btn color="error" @click="sendFollowRequest">
             <span v-if="!this.status">دنبال کردن</span>
             <span v-else>لغو دنبال کردن</span>
        </v-btn>
    </div>
</template>

<script>
import methods from '../methods';
export default {
    name: "FollowBtn",
    props:['follow','seller_id','device','followers_count','lastDate'],
    mixins:[methods],
    data(){
        return {
            status:null,
            count:0
        }
    },
    mounted() {
        this.status=this.follow !== "0";
        this.count=this.followers_count;
    },
    methods:{
        sendFollowRequest:function (){
            const url=this.$siteUrl+'/seller/follow';
            this.$root.$emit('show_progress');
            this.axios.post(url,{seller_id:this.seller_id})
                .then(response=>{
                    this.$root.$emit('hide_progress');
                    this.status=response.data;
                    if(this.status){
                        this.count++;
                    }
                    else{
                        this.count--;
                    }
                })
                .catch((error)=>{
                    this.$root.$emit('hide_progress');
                    if (error.response.status === 401) {
                        if(this.device==='mobile'){
                            this.$root.$emit('show_mobile_login');
                        }
                        else{
                            this.$root.$emit('show_desktop_login');
                        }
                    }
                })
        }
    }
}
</script>

