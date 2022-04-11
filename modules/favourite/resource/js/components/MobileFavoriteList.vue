<template>
    <div class="favorite_list">

        <div v-for="(item,key) in FavoriteList.data" v-bind:key="item.id" class="favorite_product">
            <div>
                <img v-bind:src="$siteUrl+'/files/thumbnails/'+item.product.image_url" >
            </div>

            <div>

                <a  @click="show_product(item.product)" style="color:black">
                    {{ item.product.title}}
                </a>

                <div class="score">

                    <div class="gray" v-bind:style="{ backgroundImage: 'url(' + getImageUrl() + ')' }">
                        <div class="score-size" :style="{width:getScoreValue(item.product)+'%',backgroundImage: 'url(' + getImageUrl() + ')'}"></div>
                    </div>

                </div>


                <div>
                     <span class="product_price" v-if="item.product.status==1">
                              {{ replaceNumber(number_format(item.product.price)) }} تومان
                     </span>
                     <span class="product_price" v-else>
                            <span v-if="item.product.status==-1">توقف تولید</span>
                           <span v-else>ناموجود</span>
                     </span>
                </div>

                <div class="favorite_footer">
                    <v-btn color="primary" @click="show_product(item.product)">
                        مشاهده محصول
                    </v-btn>
                    <v-btn color="error" @click="remove_of_list(item.product.id,key)">
                        حذف محصول
                    </v-btn>

                </div>
            </div>


        </div>

        <v-dialog
            v-model="show_dialog_box"
            width="450"
        >
            <v-card>
                <v-card-text>

                    <div class="alert-div">
                        آیا مطمئنید که این محصول از لیست مورد علاقه شما حذف شود؟
                    </div>

                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="success"
                        @click="approve()"
                        class="action-btn"
                        text
                    >
                        بله
                    </v-btn>

                    <v-btn
                        color="error"
                        @click="show_dialog_box = false"
                        class="action-btn"
                        text
                    >
                        خیر
                    </v-btn>


                </v-card-actions>

            </v-card>
        </v-dialog>


        <div v-if="showLoading===false && FavoriteList.data.length===0">
            <p style="text-align:center;padding-top:30px;padding-bottom:20px">
                محصولی به لیست علاقه مندی شما اضافه نشده
            </p>
        </div>

        <v-dialog
            v-model="showLoading"
            persistent
            max-width="400px"
        >
            <v-card>

                <v-card-text>

                    <slot name="loading_box"></slot>

                    <div style="padding:30px 0px 10px 0px">
                        <v-progress-linear
                            color="red darken-1"
                            indeterminate
                            rounded
                            height="6"
                        ></v-progress-linear>
                    </div>


                </v-card-text>

            </v-card>
        </v-dialog>

    </div>
</template>
<script>
import methods from "../methods";
export default ({
    name:"MobileFavoriteList",
    mixins:[methods],
    data(){
        return{
            FavoriteList:{data:[]},
            remove_id:0,
            show_dialog_box:false,
            showLoading:false,
            page:1,
            favorite_list_height:0,
            scroll_height:0,
            getServerData:true,
            show_loading_box:false,
            select_key:0,
            loading:true
        }
    },
    props:['shop_product_url'],
    mounted(){
        this.getList();
        this.scroll();
    },
    methods: {
        getList: function (page = 1) {
            this.showLoading = true;
            const url = this.$siteUrl + "/user/getFavoriteList?page=" + page;
            const app=this;
            this.axios.get(url).then(response => {
                this.showLoading = false;
                response.data.data.forEach(function(item){
                    app.FavoriteList.data.push(item);
                });
                if(response.data.data.length===0)
                {
                    this.getServerData=false;
                }
            }).catch(error => {
                this.showLoading = false;
            });
        },
        remove_of_list:function(id,key){
            this.remove_id=id;
            this.select_key=key
            this.show_dialog_box=true;
        },
        approve:function(){
            this.showLoading=true;
            this.show_dialog_box=false;
            const url=this.$siteUrl+"/user/favorite/list/remove?showMobile=ok";
            const formdata=new FormData();
            formdata.append('product_id',this.remove_id);
            this.axios.post(url,formdata).then(response=>{
                this.showLoading=false;
                if(response.data==='ok'){
                    this.$delete(this.FavoriteList.data,this.select_key);
                }
            }).catch(error=>{
                this.showLoading=false;
            });
        },
        scroll () {
            const self=this;
            window.onscroll = () => {
                let bottomOfWindow = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) + window.innerHeight === document.documentElement.offsetHeight
                if (bottomOfWindow && self.getServerData && this.showLoading===false) {
                    this.page=this.page+1;
                    this.getList( this.page);
                }
            }
        }
    }
})
</script>

<style>
  @import "../style.css";
</style>
