<template>
    <div style="margin:15px">

        <v-row>
            <p style="padding-bottom:10px">
                انتخاب معیار های ثبت تنوع قیمت محصولات
            </p>
        </v-row>


        <div v-for="(row,key) in select" :key="key">

            <v-row class="variation-input-box">
                <v-combobox
                    :items="selectList"
                    item-value="title"
                    item-text="title"
                    return-object
                    outlined
                    class="c-field"
                    dense
                    @change="change(select[key],key)"
                    v-model="select[key]"
                >
                </v-combobox>
                <input type="hidden" :value="inputValue[key]">


            </v-row>

            <template v-if="inputValue[key]==='Modules\\priceVariation\\Module'">

                <v-row>
                    <v-text-field
                        label="نام معیار"
                        outlined
                        dense
                        v-model="price_variation_name[key]"
                        class="c-field"
                    >

                    </v-text-field>

                    <template v-if="inputValue[key]==='Modules\\priceVariation\\Module'">
                        <div @click="add_new_input(key)">
                            <v-icon >mdi-plus</v-icon>
                        </div>
                    </template>
                </v-row>
                <v-row v-for="(i,key2) in param[key]" :key="key2">
                    <v-text-field outlined
                                  dense
                                  placeholder="مقدار"
                                  v-model="param[key][key2].variation_value"
                                  class="c-field"
                    >

                    </v-text-field>
                    <div v-if="param[key][key2]['id']>0">
                        <span class="delete_link" @click="showDialogBox(param[key][key2]['id'])">حذف</span>
                    </div>
                </v-row>

            </template>


        </div>

        <v-row>
            <v-btn @click="send_data()">
                ثبت
            </v-btn>
        </v-row>



        <v-dialog
            v-model="dialog"
            width="450"
        >
            <v-card>
                <v-card-text>

                    <div class="alert-div">
                        آیا از حذف این ایتم مطمئن هستین؟
                    </div>

                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="success"
                        @click="sendRequest()"
                        class="action-btn"
                        text
                    >
                        بله
                    </v-btn>

                    <v-btn
                        color="error"
                        @click="dialog = false"
                        class="action-btn"
                        text
                    >
                        خیر
                    </v-btn>


                </v-card-actions>

            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        name: "AddProductVariation",
        props:['items','price_variation_param','category'],
        data(){
            return {
                selectList:[],
                select:[null,null],
                inputValue:[null,null],
                param:[
                    [],
                    []
                ],
                price_variation_name:[],
                dialog:false,
                selectId:0
            }
        },
        mounted() {
            this.setList();
            this.$nextTick(function () {
                for (let i = 0; i <this.selectList.length ; i++) {
                    if(this.selectList[i].id===this.category['price_variation_item1']){
                        this.select[0]=this.selectList[i]['title'];
                        this.inputValue[0]=this.selectList[i].id;
                    }
                    if(this.selectList[i].id===this.category['price_variation_item2']){
                        this.select[1]=this.selectList[i]['title'];
                        this.inputValue[1]=this.selectList[i].id;
                    }
                }

                const price_variation_param=this.price_variation_param;
                const keys=Object.keys(price_variation_param);
                for (let i = 0; i <keys.length ; i++) {
                    this.param[keys[i]]=price_variation_param[keys[i]];
                    this.price_variation_name[keys[i]]=price_variation_param[keys[i]][0]['variation_name'];
                }

                this.$forceUpdate();
            });
        },
        methods:{
            setList:function () {
                const keys=Object.keys(this.items);
                let newList=[];
                for (let i = 0; i <keys.length ; i++) {
                    newList.push({
                        'id':keys[i],
                        'title':this.items[keys[i]]
                    });
                }
                this.selectList=newList;
            },
            change:function (value,index) {
                this.inputValue[index]=value['id'];
                if(  this.inputValue[index]==='Modules\\priceVariation\\Module'){
                    if(this.param[index].length===0){
                        this.param[index].push({'id':0,'variation_value':''});
                        this.price_variation_name.push('');
                    }
                }
            },
            add_new_input:function (key) {
                this.param[key].push({'id':0,'variation_value':''});
                this.$forceUpdate();
            },
            send_data:function () {
                const formData={};

                formData['price_variation_name']=this.price_variation_name;
                formData['price_variation']=this.inputValue;
                formData['price_variation_item']=this.param;

                const url=this.$siteUrl+'/admin/category/'+this.category['id']+'/price_variation';
                this.$root.$emit('send_post_request',url,formData);
            },
            showDialogBox:function (id) {
                this.selectId=id;
                this.dialog=true;
            },
            sendRequest:function () {
                this.dialog=false;
                const  url=this.$siteUrl+"/admin/category/price_variation/"+this.selectId;
                this.$root.$emit('send_delete_request',url);
            }
        }
    }
</script>

<style>
    .variation-input-box .v-icon{
        height:30px;
        margin-right:15px;
    }
    .delete_link{
        cursor:pointer;
        color: red;
        font-size:14px;
        margin-right:20px;
    }
</style>
