<template>
    <div>

        <v-navigation-drawer
            v-model="drawer"
            fixed
            temporary
            width="100%"
            right
        >
            <v-app-bar
                fixed
                elevation="0"
            >
                <div style="padding-left:10px">
                    <v-icon @click="drawer=!drawer">mdi-arrow-right</v-icon>
                </div>
                <v-toolbar-title>مشخصات فنی</v-toolbar-title>

            </v-app-bar>

            <div style="padding-top:30px"></div>

            <div v-if="hasItem">

                <table class="item_table">

                    <template v-for="item in items">
                        <tr>
                            <td colspan="2" style="padding: 15px 0px">
                                <span class="item_name">{{ item.title }}</span>
                            </td>
                        </tr>

                        <template v-for="child in item.get_child" >

                            <template v-if="child.get_value.length>0">

                                <tr>
                                    <td class="product_item_name">
                                        <p>{{ child.title }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="product_item_value">
                                        <p>{{ child.get_value[0]['item_value'] }}</p>
                                    </td>
                                </tr>

                                <template v-for="(value,key) in child.get_value">

                                    <tr v-if="key>0">
                                        <td class="product_item_value">
                                            <p>{{ value.item_value }}</p>
                                        </td>
                                    </tr>

                                </template>

                            </template>

                        </template>

                    </template>

                </table>

            </div>

            <div v-else>
                <p class="empty_message">
                    مشخصات فنی برای این محصول ثبت نشده
                </p>
            </div>

        </v-navigation-drawer>
    </div>
</template>

<script>
    export default {
        name: "MobileProductItems",
        props:['product_id'],
        data(){
            return {
                drawer:false,
                hasItem:false,
                items:[]
            }
        },
        mounted() {
            this.getItems();
            const self=this;
            this.$root.$on('show_item_box',function () {
                self.drawer=true;
            });
        },
        methods:{
            getItems:async function(){
                const url=this.$siteUrl+"/api/product/items/"+this.product_id;
                const response=await this.axios.get(url);
                if(response.status===200){
                    this.sendRequest=false;
                    this.items=response.data.original;
                    this.checkHasItem();
                    if(this.hasItem){
                        this.$root.$emit('showImportant',this.items);
                    }
                }
                else{
                    this.sendRequest=false;
                }
            },
            checkHasItem:function () {
                for (let i = 0; i <this.items.length ; i++) {
                    const child=this.items[i].get_child;
                    for (let j = 0; j <child.length ; j++) {
                        if(child[j].get_value.length>0 && this.hasItem===false){
                            this.hasItem=true;
                        }
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .item_table{
        width:calc(100% - 24px);
    }
    .item_table p{
        margin: 0px !important;
        padding:0px !important;
    }
</style>
