<template>
    <div class="data-table">
        <v-data-table
            :headers="tableHeader"
            :items="items"
            class="data-table"
            v-resize="onResize"
            hide-default-footer
        >
            <template v-slot:item="{item}">

                <tr v-if="!isMobile" @contextmenu="show">
                    <td  @contextmenu="setRowId(item.id,item.seller_id)" v-for="(row,key) in tableHeader" style="text-align: center" :class="key===0 ? 'first-td' : ''">
                        <dynamic-component :template="item['column'+key]"></dynamic-component>
                    </td>
                </tr>
                <tr v-else>
                    <td>
                        <ul class="table-ul">
                            <li v-for="(row,key) in tableHeader">
                                <span class="li-title">{{ row.text }}</span>
                                <dynamic-component :template="item['column'+key]"></dynamic-component>
                            </li>
                        </ul>
                    </td>
                </tr>

                <v-menu
                    v-model="showMenu"
                    absolute
                    offset-y
                    :position-x="x"
                    :position-y="y"
                    content-class="right-menu-box"
                    v-if="Object.keys(right_click).length>0">
                    <v-list>

                        <v-list-item-title v-for="(event,key) in rightClickItems" :key="key">
                            <a @click="get_page_content(event)">
                                <v-icon>{{ event['icon'] }}</v-icon>
                                {{ event['label'] }}
                            </a>
                        </v-list-item-title>

                    </v-list>
                </v-menu>

            </template>

        </v-data-table>
    </div>
</template>

<script>
    const dynamicComponent={
        template:'',
        props:['template'],
        functional:true,
        render:function (h,context) {
            let template=context.props.template;
            template='<div>'+template+'</div>';
            const component={ template };
            return h(component);
        }
    };
    export default {
        name: "SellerProductList",
        props:['headers','items','right_click','seller_id'],
        data () {
            return {
                tableHeader:[],
                isMobile:false,
                showMenu:false,
                x: 0,
                y: 0,
                rowId:'',
                rightClickItems:[],
                product_seller_id:0
            }
        },
        mounted() {
            const h=this.headers;
            for (let i = 0; i <h.length; i++) {
                h[i].value='column'+i;
                h[i].sortable=false;
            }
            this.tableHeader=h;
            this.$nextTick(function () {
                this.$root.$emit('addLoadEvent','data-table');
            });
        },
        methods:{
            onResize:function () {
                if(window.innerWidth<769){
                    this.isMobile=true;
                    const data_table=document.getElementsByClassName('data-table');
                    for (let i = 0; i <data_table.length ; i++) {
                        data_table[i].querySelector('.v-data-table-header').style.display='none';
                    }
                }
                else{
                    this.isMobile=false;
                    const data_table=document.getElementsByClassName('data-table');
                    for (let i = 0; i <data_table.length ; i++) {
                        data_table[i].querySelector('.v-data-table-header').style.display='contents';
                    }
                }
            },
            show (e) {
                e.preventDefault()
                this.showMenu = false;
                this.x = e.clientX;
                this.y = e.clientY;
                if(this.product_seller_id!=this.seller_id){
                     if(this.right_click['price_variation']!==undefined){
                         this.rightClickItems={'price_variation':this.right_click['price_variation']};
                     }
                }
                else {
                    this.rightClickItems=this.right_click;
                    if(this.rightClickItems['filters']!==undefined){
                        delete this.rightClickItems['filters'];
                    }
                }
                this.$nextTick(() => {
                    this.showMenu = true;
                });
            },
            get_page_content:function (event) {
                let url_param=event.url;
                url_param=url_param.replace(':id',this.rowId);
                let url=this.$siteUrl+'/sellers/panel/'+url_param;
                this.$root.$emit('send_get_request',url);
            },
            setRowId:function (id,seller_id) {
                this.rowId=id;
                this.product_seller_id=seller_id;
            }
        },
        components:{
            dynamicComponent
        }
    }
</script>

<style scoped>

</style>
