<template>
    <div>
        <v-dialog v-model="dialog" width="1100">
            <v-card>


                <v-card-text class="gallery_box_content" id="product_gallery_box">

                    <div class="right_box">
                        <div class="img_swiper" id="img_swiper">
                            <div v-for="(img,key) in images" :key="key" :class="[selected==key ? 'swiper-slide img_select_border' : 'swiper-slide']">
                                <img :src="$siteUrl+'/files/gallery/'+img.image_url" @click="showImg(img,key)"/>
                            </div>
                        </div>
                    </div>

                    <div class="left_box">

                        <v-icon @click="dialog=false">mdi-close</v-icon>

                        <div class="gallery_item" @mousedown="mousedown" @mouseup="mouseup" @mousemove="mousemove">
                            <img v-if="images.length>0"
                                 ondragstart="return false"
                                 v-on:load="set_image_width()"
                                 :src="defaultUrl" id="selected_img"
                            />
                        </div>

                        <div class="rang_slider">
                            <v-icon @click="rangeMinus()">mdi-minus</v-icon>
                            <input type="range" value="0" min="0" max="100" v-model="range" @change="zoom()">
                            <v-icon @click="rangePlus()">mdi-plus</v-icon>
                        </div>
                    </div>

                </v-card-text>

            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        name: "DesktopGallery",
        data(){
            return {
                dialog:false,
                defaultUrl:'',
                selected:0,
                range:0,
                isDown:false,
                startX:0,
                startY:0,
                scrollTop:0,
                scrollLeft:0
            }
        },
        props:['images'],
        mounted() {
            const self=this;
            if(this.images.length>0){
                this.defaultUrl=this.$siteUrl+'/files/gallery/'+this.images[0]['image_url'];
            }
            const gallery_ul=document.querySelector('.gallery_ul');
            for (let i = 0; i <gallery_ul.childNodes.length ; i++) {
                gallery_ul.childNodes[i].addEventListener('click',function () {
                    self.dialog=true;
                });
            }
        },
        methods:{
            set_image_width:function () {
                const selected_img=document.getElementById('selected_img');
                if(selected_img!=null)
                {
                    if(selected_img.naturalHeight>selected_img.naturalWidth)
                    {
                        selected_img.setAttribute('width','40%');
                        selected_img.setAttribute('nw','40');
                    }
                    else if(selected_img.naturalWidth>600 && selected_img.naturalHeight<720)
                    {
                        selected_img.setAttribute('width','65%');
                        selected_img.setAttribute('nw','65');
                    }
                    else{
                        selected_img.setAttribute('width','55%');
                        selected_img.setAttribute('nw','55');
                    }
                }
            },
            mousedown:function (event) {
                const gallery_item=document.querySelector('.gallery_item');
                this.isDown=true;
                this.startX=event.pageX-gallery_item.offsetLeft;
                this.startY=event.pageY-gallery_item.offsetTop;
                this.scrollLeft=gallery_item.scrollLeft;
                this.scrollTop=gallery_item.scrollTop;
            },
            mouseup:function () {
                this.isDown=false;
            },
            mousemove:function (event) {
                const gallery_item=document.querySelector('.gallery_item');
                if(!this.isDown) return ;
                event.preventDefault();
                const x= event.pageX - gallery_item.offsetLeft;
                const y=event.pageY - gallery_item.offsetTop;

                const x1=(x-this.startX)*2;
                const y1=(y-this.startY)*2;
                gallery_item.scrollLeft=(this.scrollLeft-x1);
                gallery_item.scrollTop=(this.scrollTop-y1);
            },
            zoom:function () {
                const gallery_item=document.querySelector('.gallery_item');
                const nw=parseFloat(document.querySelector("#selected_img").getAttribute('nw'));

                let new_width=nw+(2*this.range);
                new_width=new_width+'%';

                document.querySelector("#selected_img").style.width=new_width;

                const scrollWidth=gallery_item.scrollWidth;
                const offsetWidth=gallery_item.offsetWidth;

                const scrollHeight=gallery_item.scrollHeight;
                const offsetHeight=gallery_item.offsetHeight;

                const a=(scrollWidth-offsetWidth)/2;
                const b=(scrollHeight-offsetHeight)/2;

                gallery_item.scroll(-a,b);
            },
            rangePlus:function () {
                if(this.range<=95){
                    this.range=(this.range+5);
                    this.zoom();
                }
            },
            rangeMinus:function () {
                if(this.range>=5){
                    this.range=(this.range-5);
                    this.zoom();
                }
            },
            showImg:function(img,key){
                this.selected=key;
                this.defaultUrl=this.$siteUrl+'/files/gallery/'+img['image_url'];
                this.range=0;
                this.zoom();

                const n=key+1;
                let new_value=(n*50);
                new_value=200-new_value;
                if(n==1)
                {
                    new_value=200;
                }
                const newTransform="translate3d(0px,"+new_value+"px,0px)";
                document.getElementById("img_swiper").style.transform=newTransform;
            }
        }
    }
</script>

<style scoped>
    @import "../../assets/css/style.css";
</style>
