<template>
    <div>

        <div class="filter_header">

            <v-btn @click="drawer=true">
                <v-icon>mdi-filter</v-icon>
                جستجوی پیشرفته
            </v-btn>

            <v-btn @click="sortDrawer=!sortDrawer">
                <v-icon>mdi-sort-variant</v-icon>
                مرتب سازی
            </v-btn>

        </div>


        <slot name="product-list" v-if="hasFilter===false"></slot>



        <template v-if="products.data.length>=0 &&  clientRequest===true">

            <template v-for="p in products.data">
                <slot name="layout" :product="p"></slot>
            </template>

            <div v-if="products.data.length===0 && hasFilter" class="not_fount_product_message">
                محصولی برای نمایش یافت نشد
            </div>

        </template>

        <template v-if="sendProductRequest===true">

            <div v-for="i in 2" class="product_div"  style="padding:15px">
                <div class="product_info_div">
                    <div class="image_box">
                        <v-skeleton-loader
                            type="image"
                            height="120"
                        ></v-skeleton-loader>
                    </div>
                    <div class="product-info">
                        <v-skeleton-loader
                            type="list-item-two-line"
                        ></v-skeleton-loader>
                    </div>
                </div>
            </div>

        </template>

        <v-navigation-drawer
            v-model="drawer"
            right
            fixed
            app
            width="100%"
            class="app-filter-box"
        >
            <v-app-bar
                fixed
                elevation="0"
            >
                <div style="padding-left:10px">
                    <v-icon @click="drawer=!drawer">mdi-arrow-right</v-icon>
                </div>
                <v-toolbar-title>{{ cat_name }}</v-toolbar-title>

            </v-app-bar>

            <div style="padding-top:40px"></div>

            <div v-if="sendRequest">
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
                <v-expansion-panels style="padding:20px 0px">

                    <v-expansion-panel v-if="filterList['child_category']!==undefined && filterList['child_category'].length>0">
                        <v-expansion-panel-header>
                            <span>دسته بندی ها</span>
                        </v-expansion-panel-header>

                        <v-expansion-panel-content>

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

                        </v-expansion-panel-content>
                    </v-expansion-panel>

                    <v-expansion-panel v-if="filterList['brands']!==undefined">
                        <v-expansion-panel-header>
                            <span>برند</span>
                        </v-expansion-panel-header>

                        <v-expansion-panel-content>
                            <div style="margin:10px"  v-if="filterList['brands'].length>9">
                                <v-text-field
                                    hide-details
                                    dense
                                    outlined
                                    placeholder="جست و جو ..."
                                    v-model="searchText['brand']"
                                ></v-text-field>
                            </div>

                            <v-list dense v-if="filterList['brands']!==undefined">
                                <v-list-item-group
                                    color="primary"
                                >
                                    <v-list-item dense v-for="(brand,key) in filterList['brands']" :key="key" v-if="brand.get_brand!==null && (searchText['brand']===undefined || brand.get_brand.brand_name.toString().indexOf(searchText['brand'])>-1)">

                                        <v-list-item-action>
                                            <v-checkbox
                                                v-model="checkbox['brand_'+brand.brand_id]"
                                                @click="addFilter('brand',brand.brand_id,'brand_')"
                                                color="red"
                                                @input="addFilterTag(brand.get_brand.brand_name)"
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

                        </v-expansion-panel-content>
                    </v-expansion-panel>

                    <v-expansion-panel>
                        <v-expansion-panel-header>
                            <span>فقط کالاهای موجود</span>

                            <template v-slot:actions>
                                <v-switch
                                    v-model="has_product"
                                    hide-details
                                    @click="setHasProduct"
                                ></v-switch>
                            </template>
                        </v-expansion-panel-header>
                    </v-expansion-panel>

                    <v-expansion-panel>
                        <v-expansion-panel-header>
                            <span>جست و جو در نتایج</span>
                        </v-expansion-panel-header>

                        <v-expansion-panel-content>
                            <v-text-field outlined
                                          placeholder="نام محصول  مورد نظر خود را بنوسید ..."
                                          v-model="searchTextString"
                                          hide-details
                                          dense
                                          @keyup.enter="searchProduct()"
                            ></v-text-field>
                        </v-expansion-panel-content>
                    </v-expansion-panel>

                    <v-expansion-panel>
                        <v-expansion-panel-header>
                            <span>فقط کالاهای آماده ارسال</span>
                            <template v-slot:actions>
                                <v-switch
                                    v-model="has_ready_to_shipment"
                                    hide-details
                                    @click="setHasReadyToShipment"
                                ></v-switch>
                            </template>
                        </v-expansion-panel-header>
                    </v-expansion-panel>

                    <v-expansion-panel  v-if="filterList['colors']!==undefined && filterList['colors'].length>0">
                        <v-expansion-panel-header>
                            <span>رنگ ها</span>
                        </v-expansion-panel-header>

                        <v-expansion-panel-content>
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
                                                v-model="checkbox[color.id]"
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
                        </v-expansion-panel-content>
                    </v-expansion-panel>

                    <template v-if="filterList['customItems']!==undefined">
                        <v-expansion-panel v-for="(row,key) in filterList['customItems']" class="filter-box" :key="key">

                            <v-expansion-panel-header>
                                <span>{{   row.title   }}</span>
                            </v-expansion-panel-header>

                            <v-expansion-panel-content style="padding: 0px">
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
                          </v-expansion-panel-content>
                        </v-expansion-panel>
                    </template>

                    <v-expansion-panel>
                        <v-expansion-panel-header>
                            <span>قیمت</span>
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
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
                        </v-expansion-panel-content>
                    </v-expansion-panel>

                    <template v-if="filterList['filter']!==undefined">

                        <v-expansion-panel v-for="(filter,key) in filterList['filter']"  :key="key">
                            <v-expansion-panel-header>
                                <span>{{ filter.title }}</span>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <div style="margin:10px"  v-if="filter['get_child'].length>9">
                                    <v-text-field
                                        hide-details
                                        dense
                                        outlined
                                        placeholder="جست و جو ..."
                                        v-model="searchText['filter_'+filter.id]"
                                    ></v-text-field>
                                </div>

                                <v-list dense>
                                    <v-list-item-group
                                        color="primary"
                                    >
                                        <v-list-item dense v-for="(child,key2) in filter['get_child']" :key="key2" v-if="searchText['filter_'+filter.id]===undefined || child.title.toString().indexOf(searchText['filter_'+filter.id])>-1">

                                            <v-list-item-action>
                                                <v-checkbox
                                                    color="red"
                                                    v-model="checkbox['attribute_'+child.id]"
                                                    @click="addFilter('attribute['+filter.id+']',child.id,'attribute_')">

                                                </v-checkbox>
                                            </v-list-item-action>

                                            <v-list-item-content >
                                                <span>{{ child.title }}</span>
                                            </v-list-item-content>

                                        </v-list-item>
                                    </v-list-item-group>
                                </v-list>

                            </v-expansion-panel-content>
                        </v-expansion-panel>

                    </template>

                </v-expansion-panels>
                <div style="padding-top:40px"></div>
                <v-btn color="error" class="filter-btn" @click="filterProduct">
                    فیلتر محصولات
                </v-btn>
            </div>

        </v-navigation-drawer>

        <v-navigation-drawer
            v-model="sortDrawer"
            width="100%"
            bottom
            app
            height="270"
        >
            <v-card>
                <v-card-title style="padding-bottom: 0px">
                    مرتب سازی بر اساس
                </v-card-title>
                <v-card-text>
                    <v-radio-group v-model="sort">
                        <v-radio :value="21" @click="sortProduct()" label="پربازدید ترین"></v-radio>
                        <v-radio :value="22" @click="sortProduct()" label="محبوب ترین"></v-radio>
                        <v-radio :value="23" @click="sortProduct()" label="جدید ترین"></v-radio>
                        <v-radio :value="24" @click="sortProduct()"  label="ارزان ترین"></v-radio>
                        <v-radio :value="25" @click="sortProduct()" label="گران ترین"></v-radio>
                    </v-radio-group>
                </v-card-text>
            </v-card>
        </v-navigation-drawer>
    </div>
</template>

<script>
    import methods from "../methods";

    export default {
        name: "MobileFilterList",
        data(){
            return {
                drawer:false,
                sortDrawer:false,
                filterList:{},
                boxStatus:{
                    'brand':true,
                },
                checkbox:{},
                search_url:'',
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
                mobileApp:true,
                getServerData:'ok',
                page:1,
                hasFilter:false
            }
        },
        props:['cat_id','max_price','cat_name'],
        mounted() {
            this.getFilterList();
            this.scroll();
            let params=new window.URLSearchParams(window.location.search);
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
        methods:{
            scroll () {
                const self=this;
                window.onscroll = () => {
                    let bottomOfWindow = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) + window.innerHeight === document.documentElement.offsetHeight

                    if (bottomOfWindow && self.getServerData==='ok' && this.sendProductRequest===false) {
                        this.page=this.page+1;
                        this.add_url_param('page',this.page);
                        this.setPageUrl(this.search_url,true);
                        this.search_url='';
                    }
                }
            }
        }
    }
</script>

