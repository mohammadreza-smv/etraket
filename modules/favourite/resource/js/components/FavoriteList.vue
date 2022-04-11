<template>
    <div class="favorite_list">

        <div style="display:flex;margin-bottom:20px" v-for="index in 3" :key="index" v-if="sendRequest">

            <v-skeleton-loader
                type="image"
                width="200px"
                height="200px"
            ></v-skeleton-loader>

            <v-skeleton-loader
                width="calc(100% - 200px)"
                type="list-item-three-line"
            ></v-skeleton-loader>

        </div>

        <div v-for="item in FavoriteList.data" v-bind:key="item.id" class="row">
            <div class="col-3">
                <div v-on:click="remove_of_list(item.product.id)">
                    <v-icon color="red">mdi-delete</v-icon>
                </div>
                <img v-bind:src="$siteUrl+'/files/thumbnails/'+item.product.image_url" >
            </div>

            <div class="col-9">
                <div>
                    <a  @click="show_product(item.product)" style="color:black">
                        {{ item.product.title}}
                    </a>
                    <div class="score">

                         <div class="gray" v-bind:style="{ backgroundImage: 'url(' + getImageUrl() + ')' }">
                             <div class="score-size" :style="{width:getScoreValue(item.product)+'%',backgroundImage: 'url(' + getImageUrl() + ')'}"></div>
                         </div>

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
                    <v-btn color="primary" @click="show_product(item.product)">
                        مشاهده محصول
                    </v-btn>
                </div>
            </div>
        </div>


        <favorite-pagination :pagination="FavoriteList"
                        @paginate="getList"
                        :offset="5">

        </favorite-pagination>

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


        <div v-if="sendRequest===false && FavoriteList.data.length===0">
            <p style="text-align:center;padding-top:30px;padding-bottom:20px">
                محصولی به لیست علاقه مندی شما اضافه نشده
            </p>
        </div>

    </div>
</template>
<script>
    import FavoritePagination from "./FavoritePagination";
    import methods from "../methods";
    export default({
        components:{
            FavoritePagination
        },
        name:"FavoriteList",
        data(){
            return{
                FavoriteList:{data:[]},
                remove_id:0,
                show_dialog_box:false,
                sendRequest:true
            }
        },
        props:['shop_product_url'],
        mixins:[methods],
        mounted(){
            this.getList();
        },
        methods:{
            getList:function(page=1)
            {
                this.sendRequest=true;
                this.FavoriteList={data:[]};
                const url=this.$siteUrl+"/user/getFavoriteList?page="+page;
                this.axios.get(url).then(response=>{
                    this.sendRequest=false;
                    this.FavoriteList=response.data;
                }).catch(error=>{
                    this.sendRequest=false;
                });
            },
            remove_of_list:function(id){
                this.remove_id=id;
                this.show_dialog_box=true;
            },
            approve:function(){
                this.show_dialog_box=false;
                this.sendRequest=true;
                const url=this.$siteUrl+"/user/favorite/list/remove";
                const formData=new FormData();
                formData.append('product_id',this.remove_id);
                this.axios.post(url,formData).then(response=>{
                    this.sendRequest=false;
                    this.FavoriteList=response.data;
                }).catch(error=>{
                    this.sendRequest=false;
                });
            }
        }
    })
</script>

<style>
  @import "../style.css";
</style>
