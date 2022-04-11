<template>

    <v-row id="product_box">

        <div class="col-3">

            <div  v-if="sendRequest">
                <v-card class="filter-box">
                    <v-skeleton-loader
                        type="list-item-three-line"
                    ></v-skeleton-loader>
                </v-card>

                <v-card v-if="sendRequest" class="filter-box">
                    <v-skeleton-loader
                        type="list-item-three-line"
                    ></v-skeleton-loader>
                </v-card>
            </div>

            <div v-else>

                <slot name="before-filter-list"></slot>

                <v-card v-if="selected_filter.length>0" class="filter-box">

                    <v-card-title style="cursor:pointer" >
                        <span>فیلتر های اعمال شده</span>
                    </v-card-title>

                    <v-card-text style="display: flex;flex-wrap:wrap">
                        <div v-for="(item,key) in selected_filter" class="selected-filter" @click="run_filter_event(item,key)">
                            <span>{{ item.label1 }} : </span>
                            <span>{{ item.label2 }}</span>
                            <v-icon size="12">mdi-close</v-icon>
                        </div>
                    </v-card-text>
                </v-card>

                <v-card v-if="filterList['child_category']!==undefined && filterList['child_category'].length>0"
                        class="filter-box">

                    <v-card-title style="cursor:pointer" @click="changeStatus('child_category')">
                        <span>دسته بندی ها</span>
                        <v-spacer></v-spacer>
                        <v-icon v-if="boxStatus['child_category']!==true">mdi-chevron-down</v-icon>
                        <v-icon v-else>mdi-chevron-up</v-icon>
                    </v-card-title>

                    <v-card-text  v-if="boxStatus['child_category']===true">
                        <div class="child-cat-list-title">
                            <v-icon>mdi-chevron-down</v-icon>
                            {{ filterList['category']['name'] }}
                        </div>
                        <ul class="child-cat-ul">
                            <li v-for="cat in filterList['child_category']">
                                <a @click="$root.$emit('send_get_request',$siteUrl+'/search/'+cat['url'])">
                                    <v-icon>mdi-chevron-left</v-icon>
                                    <span>{{ cat['name'] }}</span>
                                </a>
                            </li>
                        </ul>
                    </v-card-text>

                </v-card>

                <v-card v-if="filterList['brands']!==undefined && filterList['brands'].length>0" class="filter-box">

                    <v-card-title style="cursor:pointer" @click="changeStatus('brand')">
                        <span>برند</span>
                        <v-spacer></v-spacer>
                        <v-icon v-if="boxStatus['brand']!==true">mdi-chevron-down</v-icon>
                        <v-icon v-else>mdi-chevron-up</v-icon>
                    </v-card-title>

                    <v-card-text style="padding: 0px" v-if="boxStatus['brand']===true">

                        <div style="margin:10px"  v-if="filterList['brands'].length>9">
                            <v-text-field
                                hide-details
                                dense
                                outlined
                                placeholder="جست و جو ..."
                                v-model="searchText['brand']"
                            ></v-text-field>
                        </div>

                        <v-list dense>
                            <v-list-item-group
                                color="primary"
                            >
                                <v-list-item dense v-for="(brand,key) in filterList['brands']" :key="key"
                                             v-if="brand.get_brand!==null && brand.get_brand.brand_name!=='' &&
                                             (searchText['brand']===undefined ||
                                             brand.get_brand.brand_name.toString().indexOf(searchText['brand'])>-1)">

                                    <v-list-item-action>
                                        <v-checkbox
                                            v-model="checkbox['brand_'+brand.brand_id]"
                                            @click="addFilter('brand',brand.brand_id,'brand_')"
                                            color="red"

                                        >
                                        </v-checkbox>

                                    </v-list-item-action>

                                    <v-list-item-content >
                                        <div style="display: flex;justify-content: space-between">
                                            <span>{{ brand.get_brand.brand_name }}</span>
                                            <span>{{ brand.get_brand.brand_ename }}</span>
                                        </div>
                                    </v-list-item-content>

                                </v-list-item>
                            </v-list-item-group>
                        </v-list>

                    </v-card-text>

                </v-card>

                <v-card class="filter-box">
                    <v-card-text style="padding:1px 10px 20px 10px">

                        <v-switch
                            v-model="has_product"
                            label="فقط کالاهای موجود"
                            hide-details
                            @click="setHasProduct"
                        ></v-switch>

                    </v-card-text>
                </v-card>


                <v-card v-if="filterList['colors']!==undefined && filterList['colors'].length>0" class="filter-box">

                    <v-card-title style="cursor:pointer" @click="changeStatus('color')">
                        <span>رنگ ها</span>
                        <v-spacer></v-spacer>
                        <v-icon v-if="boxStatus['color']!==true">mdi-chevron-down</v-icon>
                        <v-icon v-else>mdi-chevron-up</v-icon>
                    </v-card-title>

                    <v-card-text style="padding: 0px" v-if="boxStatus['color']===true">

                        <div style="margin:10px"  v-if="filterList['colors'].length>9">
                            <v-text-field
                                hide-details
                                dense
                                outlined
                                placeholder="جست و جو ..."
                                v-model="searchText['color']"
                            ></v-text-field>
                        </div>

                        <v-list dense>
                            <v-list-item-group
                                color="primary"
                            >
                                <v-list-item dense v-for="(color,key) in filterList['colors']" :key="key" v-if="searchText['color']===undefined || color.name.toString().indexOf(searchText['color'])>-1">

                                    <v-list-item-action>
                                        <v-checkbox
                                            color="red"
                                            v-model="checkbox['color_'+color.id]"
                                            @click="addFilter('color',color.id,'color_')"
                                        >

                                        </v-checkbox>
                                    </v-list-item-action>

                                    <v-list-item-content >
                                        <div style="display: flex;justify-content: space-between">
                                            <span>{{ color.name }}</span>
                                            <div :style="{backgroundColor:color.code}" class="color_div"></div>
                                        </div>
                                    </v-list-item-content>

                                </v-list-item>
                            </v-list-item-group>
                        </v-list>

                    </v-card-text>

                </v-card>

                <v-card class="filter-box">

                    <v-card-title style="cursor:pointer" >
                        <span>محدوده قیمت مورد نظر</span>
                    </v-card-title>

                    <v-card-text>

                        <v-range-slider
                            v-model="priceRange"
                            :max="max"
                            :min="min"
                            hide-details
                            style="margin:10px 0px"
                            @change="setRangePrice"

                        ></v-range-slider>

                        <ul class="filter_price_ul">
                            <li>
                                <div>از</div>
                                <div class="price">{{ replaceNumber(number_format(priceRange[0])) }}</div>
                                <div>تومان</div>
                            </li>
                            <li>
                                <div>تا</div>
                                <div class="price">{{ replaceNumber(number_format(priceRange[1])) }}</div>
                                <div>تومان</div>
                            </li>
                        </ul>

                        <div style="display: flex;justify-content: center;padding-top:10px">
                            <v-btn color="primary" @click="priceFilter()">
                                <v-icon>mdi-filter</v-icon>
                                اعمال محدوده قیمت
                            </v-btn>
                        </div>

                    </v-card-text>

                </v-card>

                <v-card class="filter-box">
                    <v-card-title style="cursor:pointer" >
                        <span>جست و جو در نتایج</span>
                    </v-card-title>
                    <v-card-text style="padding:15px 10px">
                        <v-text-field outlined
                                      placeholder="نام محصول  مورد نظر خود را بنوسید ..."
                                      v-model="searchTextString"
                                      hide-details
                                      dense
                                      @keyup.enter="searchProduct()"
                        ></v-text-field>

                    </v-card-text>
                </v-card>

                <v-card class="filter-box">
                    <v-card-text style="padding:1px 10px 20px 10px">

                        <v-switch
                            v-model="has_ready_to_shipment"
                            label="فقط کالاهای آماده ارسال"
                            hide-details
                            @click="setHasReadyToShipment"
                        ></v-switch>

                    </v-card-text>
                </v-card>

                <template v-if="filterList['customItems']!==undefined">
                    <v-card v-for="(row,key) in filterList['customItems']" class="filter-box" :key="key">

                        <v-card-title style="cursor:pointer" @click="changeStatus(row.param)">
                            <span>{{ row.title }}</span>
                            <v-spacer></v-spacer>
                            <v-icon v-if="boxStatus['attribute_'+row.param]!==true">mdi-chevron-down</v-icon>
                            <v-icon v-else>mdi-chevron-up</v-icon>
                        </v-card-title>

                        <v-card-text style="padding: 0px" v-if="boxStatus[row.param]===true">
                            <div style="margin:10px"  v-if="row.items.length>9">
                                <v-text-field
                                    hide-details
                                    dense
                                    outlined
                                    placeholder="جست و جو ..."
                                    v-model="searchText['filter_'+row.param]"
                                ></v-text-field>
                            </div>

                            <v-list dense>
                                <v-list-item-group
                                    color="primary"
                                >
                                    <v-list-item dense v-for="(item,key2) in row.items" :key="key2"
                                                 v-if="searchText[row.param+'_'+row.param]===undefined ||
                                                 item.title.toString().indexOf(searchText[row.param+'_'+row.param])>-1">

                                        <v-list-item-action>
                                            <v-checkbox
                                                color="red"
                                                v-model="checkbox[row.param+'_'+item.id]"
                                                @click="addFilter(row.param,item.id,row.param+'_')">

                                            </v-checkbox>
                                        </v-list-item-action>

                                        <v-list-item-content >
                                            <span>{{ item.title }}</span>
                                        </v-list-item-content>

                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-card-text>
                    </v-card>
                </template>


            </div>

        </div>

        <div class="col-9">

            <slot name="before-product-list"></slot>

            <div class="product_list_box">

                <div class="header">
                    <ul class="sort-ul">
                        <li><span class="fa fa-sort-amount-asc"></span>مرتب سازی بر اساس : </li>
                        <li :class="sort==21 ? 'active' : ''" v-on:click="set_sort(21)"><a><span>پربازدید ترین</span></a></li>
                        <li :class="sort==22 ? 'active' : ''" v-on:click="set_sort(22)"><a><span>محبوب ترین</span></a></li>
                        <li :class="sort==23 ? 'active' : ''" v-on:click="set_sort(23)"><a><span>جدید ترین</span></a></li>
                        <li :class="sort==24 ? 'active' : ''" v-on:click="set_sort(24)"><a><span>ارزان ترین</span></a></li>
                        <li :class="sort==25 ? 'active' : ''" v-on:click="set_sort(25)"><a><span>گران ترین</span></a></li>
                    </ul>
                </div>

                <div class="search_product_div product_list">

                    <slot name="product-list" v-if="products.data.length===0 && sendProductRequest===false && clientRequest===false"></slot>

                    <template v-if="sendProductRequest===true">

                        <div v-for="i in 8" class="product_div"  style="padding:15px">
                            <v-skeleton-loader
                                type=" image,list-item-two-line"
                            ></v-skeleton-loader>
                        </div>

                    </template>

                    <template v-else>

                        <template v-for="p in products.data">
                            <slot name="layout" :product="p"></slot>
                        </template>

                        <div class="product-list-paginate" v-if="products.data.length>0">
                            <product-pagination :pagination="products"
                                                @getList="paginate"
                                                :offset="5">

                            </product-pagination>
                        </div>

                        <div v-if="products.data.length===0 && sendProductRequest===false && clientRequest" class="not_fount_product_message">
                            محصولی برای نمایش یافت نشد
                        </div>

                    </template>

                </div>

            </div>


        </div>

    </v-row>

</template>

<script>
    import methods from "../methods";
    import ProductPagination from "./ProductPagination";
    export default {
        name: "DesktopFilterList",
        components: {ProductPagination},
        data(){
            return {
                filterList:{},
                boxStatus:{
                    'brand':true,
                    'child_category':true
                },
                checkbox:{},
                searchText:{},
                sendRequest:true,
                sort:21,
                products:{data:[]},
                sendProductRequest:false,
                has_product:false,
                has_ready_to_shipment:false,
                searchTextString:'',
                priceRange:[0,0],
                min:0,
                max:100,
                clientRequest:false,
                selected_filter:[]
            }
        },
        props:['cat_id','max_price'],
        mounted() {
            this.getFilterList();
            const self=this;
            this.$nextTick(function () {
                const tags=document.getElementsByClassName('search-product');
                for (let i = 0; i <tags.length ; i++) {
                    const href=tags[i].href;
                    tags[i].addEventListener('click',function (event) {
                        event.preventDefault();
                        self.setPageUrl(href);
                    });
                }
            });

            if(window.location.href.indexOf('has_product=1')>-1){
                this.has_product=true;
            }
            if(window.location.href.indexOf('has_ready_to_shipment=1')>-1){
                this.has_ready_to_shipment=true;
            }
            let params=new window.URLSearchParams(window.location.search);
            if(params.get('string')!==null){
                this.searchTextString=params.get('string');
            }

            if(this.max_price>0){
                this.max=this.max_price;
                if(params.get('price[min]')!==null){
                    this.priceRange[0]=params.get('price[min]');
                }

                if(params.get('price[max]')!==null){
                    this.priceRange[1]=params.get('price[max]');
                }
                else {
                    this.priceRange[1]=this.max_price;
                }
            }
        },
        mixins:[methods],
    }
</script>

<style>
    @import "../../css/style.css";
</style>
