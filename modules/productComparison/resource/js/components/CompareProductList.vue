<template>
    <v-dialog width="845" v-model="dialog" scrollable>
        <v-card :loading="sendRequest" :disabled="sendRequest">
            <v-card-title style="display: flex;align-items: center;">
                <v-text-field
                   label="نام کالای مورد نظرتان را وارد کنید"
                   outlined
                   style="margin-left: 10px"
                   hide-details
                   v-model="search_text"
                   @keyup.enter="search_product"
                ></v-text-field>

                <v-combobox
                    outlined
                    style="margin-right: 10px"
                    hide-details
                    :items="brandList"
                    item-text="title"
                    label="انتخاب برند"
                    @change="setBrand"
                ></v-combobox>

                <v-icon style="margin-right: 10px;" @click="dialog=false">
                    mdi-close
                </v-icon>
            </v-card-title>
            <v-card-text>
                <div style="display: flex;flex-wrap: wrap;" >
                    <div v-for="product in productList.data" class="select_product_for_compare" v-bind:data-id="product.id"
                         v-on:click="add_compare_list(product.id)">
                        <img v-bind:src="$siteUrl+'/files/thumbnails/'+product.image_url" v-if="product.image_url!=null">
                        <p>
                            {{ product.title }}
                        </p>
                    </div>
                </div>

                <pagination
                    :pagination="productList"
                    @paginate="getProduct"
                    :offset="5"
                ></pagination>

            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
    import Pagination from "./Pagination";
    export default {
        name: "CompareProductList",
        components: {Pagination},
        data(){
            return {
                productList:{data:[]},
                brand_id:'',
                search_text:'',
                brandList:[],
                product_fail_request_count:0,
                brand_fail_request_count:0,
                brand_text:'تمام برندها',
                old_search_text:'',
                dialog:false,
                sendRequest:false
            }
        },
        props:['cat_id'],
        mounted() {
            this.getProduct();
            this.getBrand();
            this.$root.$on('show_compare_products',()=>{
               this.dialog=true;
            });
        },
        methods:{
            getProduct:function (page=1)
            {
                this.sendRequest=true;
                const url=this.$siteUrl+"/get_compare_products?page="+page;
                const formData=new FormData();
                formData.append('brand_id',this.brand_id);
                formData.append('cat_id',this.cat_id);
                formData.append('search_text',this.search_text);
                this.axios.post(url,formData).then(response=>{
                    this.productList=response.data;
                    this.sendRequest=false;
                }).catch(error=>{
                    this.sendRequest=false;
                    if(this.product_fail_request_count<2){
                        this.getProduct(1);
                        this.product_fail_request_count++;
                    }
                });
            },
            add_compare_list:function (product_id) {
                let url=window.location.href;
                if(url.split(this.$productUrlParam+product_id).length==1){
                    url=url+this.$productUrlParam+product_id;
                    this.$root.$emit('send_get_request',url);
                }
            },
            getBrand:function () {
                const url=this.$siteUrl+"/site/getCatBrand";
                const formData=new FormData();
                formData.append('cat_id',this.cat_id);
                this.axios.post(url,formData).then(response=>{
                    this.brandList.push({
                        id:'',
                        title:'همه'
                    });
                     if(response.data.length>0){
                         for (let i = 0; i <response.data.length ; i++) {
                             if(response.data[i]['get_brand']!==null){
                                 this.brandList.push({
                                     id:response.data[i]['get_brand'].id,
                                     title:response.data[i]['get_brand'].brand_name
                                 });
                             }
                         }
                     }
                }).catch(error=>{
                    if(this.brand_fail_request_count<2){
                        this.getBrand();
                        this.brand_fail_request_count++;
                    }
                });
            },
            getBrandProduct:function (brand_id,brand_text) {
                this.brand_id=brand_id;
                this.brand_text=brand_text;
                this.getProduct(1);
            },
            search_product:function () {
                if(this.search_text.trim().length>1){
                    this.old_search_text=this.search_text;
                    this.getProduct(1);
                }
                else if(this.search_text.trim()==='' && this.old_search_text.trim().length>1){
                    this.getProduct(1);
                }
            },
            setBrand:function (value){
                this.brand_id=value.id;
                this.getProduct(1);
            }
        }
    }
</script>

