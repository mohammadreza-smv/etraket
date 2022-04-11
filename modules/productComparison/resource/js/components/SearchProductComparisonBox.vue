<template>
   <div>
       <div class="compare_product_list" v-if="Object.keys(list).length>0 && show"
            @mouseleave="show=false"
            @mouseover="show=true"
       >
           <ul>
               <li v-for="item in list">
                   <img :src="$siteUrl+'/files/thumbnails/'+item.image_url">
                   <span style="width: 100%;">
                    {{ item.title }}
                </span>
                   <v-icon @click="remove_of_list(item.id)">
                       mdi-delete
                   </v-icon>
               </li>
           </ul>
           <span class="empty_compare_list">انصراف</span>
       </div>

       <a  id="compare_list" v-if="Object.keys(list).length>0"
           @click="compare_product_request"
           @mouseleave="show=false"
           @mouseover="show=true"
       >
           <div ><span>مقایسه</span>
               <span>{{ Object.keys(list).length }}</span>
               <span>کالا
               </span>
           </div>
       </a>
   </div>
</template>

<script>
export default {
    name: "SearchProductComparisonBox",
    data(){
        return {
            list:{},
            baseUrl:'',
            show:false
        }
    },
    mounted() {
        this.$root.$on('compare-event',(id,title,image_url)=>{
            if(this.list[id]===undefined){
                this.list[id]={'title':title,'image_url':image_url,'id':id};
                this.$forceUpdate();
            }
            else {
                delete this.list[id];
                this.$forceUpdate();
            }
        });

        this.$root.$on('show_progress',()=>{
             if(window.location.href!==this.baseUrl){
                 this.list={};
             }
        });

        let  url= window.location.href;
        url=url.split('?');
        url=url.length===2 ? url[0] : url[1];

        this.baseUrl=url;
    },
    methods:{
        compare_product_request:function (){
            const keys=Object.keys(this.list);
            if(keys.length>0){
                let url=this.$siteUrl+'/compare';
                for (let i = 0; i <keys.length ; i++) {
                    url=url+'/dkp-'+keys[i];
                }
                this.$root.$emit('send_get_request',url);
            }
        },
        remove_of_list(id){
            delete this.list[id];
            this.$root.$emit('remove_product_of_compare_list',id);
            this.$forceUpdate();
        }
    }
}
</script>

<style scoped>
@import "../style.css";
</style>
