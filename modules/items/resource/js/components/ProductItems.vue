<template>
    <div class="item_content">

        <div v-if="sendRequest">
            <div class="progress">
                <v-progress-circular indeterminate color="red"></v-progress-circular>
            </div>
        </div>

        <div v-else>
            <div v-if="hasItem">
                <h3>مشخصات فنی</h3>
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
                                     <td class="product_item_value">
                                         <p>{{ child.get_value[0]['item_value'] }}</p>
                                     </td>
                                 </tr>

                                 <template v-for="(value,key) in child.get_value">

                                     <tr v-if="key>0">
                                         <td class="product_item_name">
                                         </td>
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
        </div>

    </div>
</template>

<script>
    export default {
        name: "ProductItems",
        props:['product_id'],
        data(){
            return {
                sendRequest:true,
                hasItem:false,
                items:[]
            }
        },
        mounted() {
            this.getItems();
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
    .progress{
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .item_table{
        width:calc(100% - 24px);
    }
    .product_item_value{
        padding-right:10px;
    }
    .item_name {
        position: relative;
        padding-right: 15px;
        padding-top: 5px;
        font-size: 14px;
    }
    .item_name::before {
        content: "";
        position: absolute;
        right: 0;
        bottom: 7px;
        width: 0;
        height: 0;
        border-color: transparent transparent transparent #00bfd6;
        border-style: solid;
        border-width: 7px 0 0 7px;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    @media (max-width:960px) {
        .product_item_name p{
            margin: 0px !important;
            padding:0px !important;
        }

    }
    .product_item_value p {
        background: #F7F9FA;
        padding: 13px 21px;
        margin-bottom: 5px;
        margin-top: 5px;
        font-size: 14px;
    }
    .product_item_name p{
        background:#f7f9FA;
        padding:14px 18px 12px;
        margin-bottom:5px;
        margin-top:5px;
        font-size:14px;
    }
    .product_item_name{
        width:230px;
    }
</style>
