<template>
    <div style="height:inherit" class="image-slider">
        <v-skeleton-loader
            v-if="sendRequest"
            type="image"
            height="100%"
        ></v-skeleton-loader>

        <v-carousel
            v-model="model"
            hide-delimiter-background
            height="100%"
            cycle
            v-else
        >
            <v-carousel-item
                v-for="(slide,key) in sliders"
                :key="key"
            >
                <a target="_blank" :href="slide.url">
                    <img :src="getUrl(slide)" />
                </a>

            </v-carousel-item>

        </v-carousel>

    </div>
</template>

<script>
    export default {
        name: "ImageSlider",
        data(){
            return {
                sliders:[],
                model:0,
                sendRequest:true
            }
        },
        mounted() {
            const url=this.$siteUrl+'/api/app/sliders';
            this.axios.get(url).then(response=>{
                this.sliders=response.data.original;
                this.sendRequest=false;
            });
            if(window.innerWidth<769){
                document.querySelector('.image-slider').classList.add('mobile-theme');
            }
        },
        methods:{
            getUrl:function(slide){
                if(window.innerWidth<769){
                    return this.$siteUrl+'/files/slider/'+slide.mobile_image_url;
                }
                else{
                    return this.$siteUrl+'/files/slider/'+slide.image_url;
                }
            }
        }
    }
</script>

<style>
   .image-slider img{
       border-radius:8px;
       --webkit-border-radius:8px;
       height: 100%;
       width: 100%;
    }
   .mobile-theme .mdi-circle::before {
        font-size: 10px !important;
   }
   /*.v-btn--active .mdi-circle::before{*/
   /*    color:#ef394e;*/
   /*    opacity:1 !important;*/
   /*}*/
   .mobile-theme .v-btn--icon.v-size--small {
       height: 18px;
       width: 18px;
       padding: 0px;
       margin: 0px;
   }
   .mobile-theme .v-window__next{
       left:0px !important;
       display: none;
   }
   .mobile-theme .v-window__prev{
       left:0px !important;
       display: none;
   }
   .v-skeleton-loader__image{
       height:100%;
   }
</style>
