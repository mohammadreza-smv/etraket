<template>
    <div>
        <div class="product_box" v-if="!serverError">

            <div class="box_title" v-if="this.args['title']!=''" style="">
                <h6>{{ this.args['title'] }}</h6>
                <slot name="link"></slot>
            </div>

            <v-slide-group
                multiple
                show-arrows
                v-if="sendRequest===false"
            >
                <v-slide-item v-for="(product,key) in products"  :key="key ">
                    <a @click="show_product(product)">
                        <div class="product">
                            <div class="product_img_div">
                                <img :src="$siteUrl+'/files/thumbnails/'+product['image_url']">
                            </div>

                            <p class="title">
                                <span v-if="product['title'].toString().length>40">
                                     {{ product['title'].toString().substr(0,40)+'...' }}
                                </span>
                                <span v-else>
                                     {{ product['title'] }}
                                </span>
                            </p>

                            <div class="discount_price" v-if="product['discount_price']!==0 && getDiscount(product)>0">

                                <del >
                                    {{ replaceNumber(number_format((product['price']+product['discount_price'])))  }}
                                </del>
                                <span class="discount-badge">
                                           ٪{{ replaceNumber(getDiscount(product))  }}
                                </span>
                            </div>

                            <p class="price">
                                {{ replaceNumber(number_format(product['price']))+' تومان'   }}
                            </p>
                        </div>
                    </a>
                </v-slide-item>

            </v-slide-group>

            <v-slide-group v-else>

                <v-slide-item v-for="key in l"  :key="key ">
                    <div class="product">
                        <v-skeleton-loader
                            class="mx-auto"
                            type="image,list-item-two-line"
                        ></v-skeleton-loader>
                    </div>
                </v-slide-item>

            </v-slide-group>

        </div>
    </div>
</template>

<script>
    export default {
        name: "HorizontalProductList",
        props:['args','shop_product_url','request_url'],
        data(){
            return {
                products:[],
                sendRequest:true,
                l:10,
                serverError:false
            }
        },
        mounted() {
            this.getProducts();
        },
        methods:{
            getProducts:function () {
                const
                    url=this.request_url===undefined ?
                this.$siteUrl+'/shop/product-list?catList='+this.args['data']['catList']+"&sort="+this.args['data']['sort']+
                    "&product_type="+this.args['data']['product_type'] : this.request_url;
                this.axios.get(url).then(response=>{
                    this.products=response.data;
                    this.sendRequest=false
                }).catch(()=>{
                    this.serverError=true;
                });
            },
            replaceNumber: function (n) {
                if (n != undefined) {
                    n = n.toString();
                    const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                    const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                    for (let i = 0; i < find.length; i++) {
                        n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                    }
                    return n;
                }
            },
            number_format: function (num) {
                num = num.toString();
                let format = '';
                let counter = 0;
                for (let i = num.length - 1; i >= 0; i--) {
                    format += num[i];
                    counter++;
                    if (counter == 3) {
                        format += ",";
                        counter = 0;
                    }
                }
                return format.split('').reverse().join('');
            },
            getDiscount:function (product) {
                const price1=parseInt(product['price'])+parseInt(product['discount_price']);
                let d=(product['price']/price1)*100;
                d=Math.floor(d);
                return (100-d);
            },
            show_product:function (product) {
                let url=this.shop_product_url;
                url=url.replace(':id',product.id);
                url=url.replace(':product_url',product.product_url);
                this.$root.$emit('send_get_request',url,'product-page-skeleton');
            },
        }
    }
</script>

<style>
    .product .v-skeleton-loader__image{
        margin: 40px auto 20px auto;
        display: block;
        min-height:150px !important;
    }
</style>
