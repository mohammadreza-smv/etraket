<template>
    <div class="user-panel-order-list">

        <v-tabs
            v-model="tab"
            color="error"
        >
            <v-tab v-for="(title,key) in tabs" :key="key" @click="getTabOrder(key)">
                <span>{{ title }}</span>
                <span class="count" v-if="order_types[tabId[key]]['count']>0">
                    {{ replaceNumber(order_types[tabId[key]]['count']) }}
                </span>
            </v-tab>

        </v-tabs>

        <div v-if="sendRequest[tabId[tab]]===true">
            <v-skeleton-loader
                type="list-item-three-line"
            ></v-skeleton-loader>

            <v-skeleton-loader
                type="list-item-three-line"
            ></v-skeleton-loader>

            <v-skeleton-loader
                type="list-item-three-line"
            ></v-skeleton-loader>

        </div>
        <div v-else>
            <div v-if="orderList[tabId[tab]]!==undefined && orderList[tabId[tab]]['data'].length>0">

                <div class="order-item" v-for="order in orderList[tabId[tab]]['data']">

                    <div class="list-item-detail">

                        <div class="order-detail-header">

                            <div class="item-detail-row">
                                <div class="detail-item">{{ order.date }}</div>
                                <div class="detail-item">DKC-{{ replaceNumber(order.id) }}</div>
                            </div>

                            <div>
                                <a class="order-link" @click="show_order(order.id)">مشاهده سفارش</a>
                            </div>

                        </div>

                        <div class="item-detail-row">
                            <span>مبلغ کل : </span>
                            {{ order['price'] }}
                        </div>

                    </div>

                    <div class="submission" v-for="(submission,key) in order['submissions']">

                        <p>
                            <span>مرسوله </span>
                            <span>{{ replaceNumber((key+1)) }} </span>
                            <span> از</span>
                            <span>{{ replaceNumber(order['submissions'].length) }} </span>
                        </p>

                        <div class="products">
                            <template v-for="(product,key2) in submission['products']">
                                <a v-if="product.product!==undefined && product.product!==null && key2<3"
                                   :href="getUrl(product.product)" class="router-link">
                                    <img :src="$siteUrl+'/files/thumbnails/'+product.product.image_url" />
                                </a>

                            </template>
                            <v-icon v-if="submission['products'].length>3">
                                mdi-plus
                            </v-icon>
                        </div>

                    </div>

                    <div class="factor_link" v-if="order.pay_status==='ok'">
                        <a class="order-link" target="_blank" :href="$siteUrl+'/user/profile/order/'+order.id+'/factor'">فاکتور سفارش</a>
                    </div>

                </div>

                <vue-pagination :pagination="orderList[tabId[tab]]"
                                @paginate="getOrder"
                                :offset="5">

                </vue-pagination>

            </div>
            <div v-else>
                <p class="not-found-order">سفارشی یافت نشد</p>
            </div>
        </div>



    </div>
</template>

<script>
    import VuePagination from "./VuePagination";
    export default {
        name: "UserPanelOrderList",
        components:{
            VuePagination
        },
        data(){
            return {
                orderList:{},
                sendRequest:{},
                pages:{},
                tab:null,
                tabs:[

                ],
                tabId:[

                ],
            }
        },
        props:['orders','shop_product_url','order_types'],
        mounted() {
            this.orderList['wait_for_payment']=this.orders;
            const order_types_key=Object.keys(this.order_types);
            if(order_types_key.length>0){
                for (let i = 0; i <order_types_key.length ; i++) {
                    this.tabId.push(order_types_key[i]);
                    this.tabs.push(this.order_types[order_types_key[i]]['title']);
                    if(i===0){
                        this.tab=order_types_key[i];
                    }
                }
            }
        },
        methods:{
            replaceNumber: function (n) {
                if (n !==undefined) {
                    n = n.toString();
                    const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                    const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                    for (let i = 0; i < find.length; i++) {
                        n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                    }
                    return n;
                }
            },
            getUrl:function (product) {
                let url=this.shop_product_url;
                url=url.replace(':id',product.id);
                url=url.replace(':product_url',product.product_url);
                return url;
            },
            getTabOrder:function (key) {
                if(this.orderList[this.tabId[key]]===undefined)
                {
                    this.sendRequest[this.tabId[key]]=true;
                    const type=this.tabId[key];
                    const url=this.$siteUrl+'/user/profile/order/json/list?activeTab='+type;
                    this.axios.get(url).then(response=>{
                       this.orderList[this.tabId[key]]=response.data;
                       this.sendRequest[this.tabId[key]]=false;
                       this.$forceUpdate();
                    }).catch(error=>{
                         this.sendRequest[this.tabId[key]]=false;
                         this.orderList[this.tabId[key]]=[];
                    });
                }
            },
            getOrder:function (page) {
                if(this.pages[this.tabId[this.tab]]===undefined || this.pages[this.tabId[this.tab]]!==page)
                {
                    this.pages[this.tabId[this.tab]]=page;
                    this.sendRequest[this.tabId[this.tab]]=true;
                    this.$forceUpdate();
                    this.$nextTick(function () {
                        this.$vuetify.goTo(0);
                    });

                    const type=this.tabId[this.tab].toString().replaceAll('_','-');
                    const url=this.$siteUrl+'/user/profile/order/json/list?activeTab='+type+'&page='+page;
                    this.axios.get(url).then(response=>{
                        this.orderList[this.tabId[this.tab]]=response.data;
                        this.sendRequest[this.tabId[this.tab]]=false;
                        this.$forceUpdate();
                    }).catch(error=>{
                        this.sendRequest[this.tabId[this.tab]]=false;
                        this.orderList[this.tabId[this.tab]]=[];
                        this.$forceUpdate();
                    });
                }
            },
            show_order:function (order_id) {
                const url=this.$siteUrl+'/user/profile/order/'+order_id;
                this.$root.$emit('send_get_request',url);
            }
        }
    }
</script>
