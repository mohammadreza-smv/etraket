<template>

    <div>

        <div  class="items-row" v-for="(key,index1) in Object.keys(fields)"
              draggable="true"
              @dragstart="DragStart(index1)"
              @drop="Drop(index1)"
        >

            <div style="width:100%;display: flex;justify-content: space-between">

                <div style="display: flex;min-width:300px">
                    <v-text-field
                        label="نام گروه ویژگی"
                        outlined
                        class="item_input"
                        dense
                        hide-details
                        v-model="fields[key]"
                    >

                    </v-text-field>
                    <div @click="add_child_item(get_key(key))">
                        <v-icon style="margin-right:10px">mdi-plus</v-icon>
                    </div>
                </div>
                <div v-if="get_key(key)>0" class="remove-link" @click="removeItemGroup(get_key(key))">
                    حذف ایتم های {{ fields[key] }}
                </div>


            </div>

            <div style="width:100%;margin-bottom:15px" v-if="childField[get_key(key)]!=undefined">

                <div v-for="(key2,index2) in Object.keys(childField[get_key(key)])" class="child-input-list"
                     draggable="true"
                     @dragstart="childDragStart(get_key(key),index2)"
                     @drop="childDrop(get_key(key),index2)"
                     @dragover.prevent
                >
                    <div style="padding-left:10px">
                        <v-checkbox
                            v-model="childCheckBox[get_key(key)][key2]" >
                        </v-checkbox>
                    </div>
                    <v-text-field
                        label="عنوان ویژگی"
                        outlined
                        class="child_input_item"
                        dense
                        hide-details
                        v-model="childField[get_key(key)][key2]"
                    >

                    </v-text-field>

                    <div v-if="get_key(key2)>0" class="remove-link" @click="removeItem(get_key(key2))">
                        حذف ویژگی
                    </div>

                </div>

            </div>

        </div>


        <div @click="addNewGroup()" style="margin-top:10px">
            <v-icon  color="red">mdi-plus</v-icon>
        </div>


        <v-btn color="success" @click="send_data()">
            ثبت اطلاعات
        </v-btn>

        <v-dialog
            v-model="dialog"
            width="450"
        >
            <v-card>
                <v-card-text>

                    <div class="alert-div">
                        {{ msg }}
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
        name: "CatItems",
        props:['items','cat_id'],
        data(){
            return {
                fields:{},
                childField:{},
                childCheckBox:{},
                remove_key:0,
                dialog:false,
                msg:'',
                startDragRow:0,
                startDragChildKey:0,
                startDragChild:0
            }
        },
        mounted() {
            if(this.items.length===0){
               this.fields=Object.assign(this.fields,{"-1":''});
            }
            else{
                for (let i = 0; i <this.items.length ; i++) {
                    this.fields=Object.assign(this.fields,{[i+"_"+this.items[i]['id']]:this.items[i]['title']});
                    for (let j = 0; j <this.items[i]['get_child'].length ; j++) {

                        const id=this.items[i]['get_child'][j]['id'];
                        const value=this.items[i]['get_child'][j]['title'];
                        const show_item=this.items[i]['get_child'][j]['show_item'];

                        if(this.childField[this.items[i]['id']]===undefined){
                            this.childField=Object.assign(this.childField,{[this.items[i]['id']]:{[i+"_"+id]:value}});
                            this.childCheckBox=Object.assign(this.childCheckBox,{[this.items[i]['id']]:{[i+"_"+id]:show_item}});
                        }
                        else{
                            const newData=Object.assign(this.childField[this.items[i]['id']],{[i+"_"+id]:value});
                            this.childField[this.items[i]['id']]=newData;


                            const newData2=Object.assign(this.childCheckBox[this.items[i]['id']],{[i+"_"+id]:show_item});
                            this.childCheckBox[this.items[i]['id']]=newData2;
                        }
                    }
                }
            }
            this.$forceUpdate();
        },
        methods:{
            addNewGroup:function () {
                const id = document.getElementsByClassName('item_input').length + 1;
                const key="-"+id;
                this.fields=Object.assign(this.fields,{[key]:''});
                this.$forceUpdate();
            },
            add_child_item:function (key) {
                const id = -(document.getElementsByClassName('child_input_item').length + 1);
                if(this.childField[key]===undefined){
                    this.childField=Object.assign(this.childField,{[key]:{[id]:''}});
                    this.childCheckBox=Object.assign(this.childCheckBox,{[key]:{[id]:''}});
                }
                else{
                    const newData=Object.assign(this.childField[key],{[id]:''});
                    this.childField[key]=newData;


                    const newData2=Object.assign(this.childCheckBox[key],{[id]:''});
                    this.childCheckBox[key]=newData2;
                }

                this.$forceUpdate();
            },
            send_data:function () {
                const url=this.$siteUrl+'/admin/category/'+this.cat_id+'/item';
                let formData={};
                formData['item']=this.fields;
                formData['child_item']=this.childField;
                formData['check_box_item']=this.childCheckBox;
                this.$root.$emit('send_post_request',url,formData);
            },
            removeItemGroup:function (key) {
                 this.remove_key=key;
                 this.msg='آیا از حذف این ویژگی ها مطمئن هستین ؟';
                 this.dialog=true;
            },
            removeItem:function (key) {
                this.remove_key=key;
                this.msg='آیا از حذف این ویژگی مطمئن هستین ؟';
                this.dialog=true;
            },
            sendRequest:function () {
                const url=this.$siteUrl+"/admin/category/items/"+this.remove_key;
                this.$root.$emit('send_delete_request',url);
                this.dialog=false;
            },
            childDragStart:function (key,index) {
                this.startDragChild=key;
                this.startDragChildKey=index;
            },
            childDrop:function (key,index2) {
                if(this.startDragChild===key){
                    const child=this.childField[key];
                    let k=Object.keys(child);
                    k.splice(index2, 0, k.splice(  this.startDragChildKey, 1)[0]);
                    const newData= {};
                    for (let i = 0; i <k.length ; i++) {
                        const a=this.get_key(k[i]);
                        newData[i+"_"+a]=child[k[i]];
                    }
                    this.childField[key]=newData;
                    this.$forceUpdate();
                }
            },
            get_key:function (key) {
                const c=key.toString().split('_');
                if(c.length===2){
                    return c[1];
                }
                else{
                    return  key;
                }
            },
            DragStart:function (index) {
                this.startDragRow=index;
            },
            Drop:function (index2) {
                let k=Object.keys(this.fields);
                k.splice(index2, 0, k.splice(  this.startDragRow, 1)[0]);
                const newData= {};
                for (let i = 0; i <k.length ; i++) {
                    const a=this.get_key(k[i]);
                    newData[i+"_"+a]=this.fields[k[i]];
                }
                this.fields=newData;
                this.$forceUpdate();
            },
        }
    }
</script>

<style scoped>
    .item_input{
        max-width:300px;
    }
    .child_input_item{
        max-width:300px;
        margin-top:15px;
    }
    .child-input-list{
        display: flex;
        align-items: center;
    }
    .remove-link{
        color:red;
        cursor: pointer;
        font-size:15px;
        padding-right:10px;
    }
    .items-row{
        width:100%;
        margin-bottom:20px;
        background-color: rgba(250, 249, 249, 0.99);
        padding:15px;
    }
</style>
