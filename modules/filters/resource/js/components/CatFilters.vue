<template>
    <div>


        <div  class="items-row" v-for="(key,index1) in Object.keys(fields)"
              draggable="true"
              @dragstart="DragStart(index1)"
              @drop="Drop(index1)"
        >

            <div style="width:100%;display: flex;justify-content: space-between">

                <div style="display: flex;">
                    <slot name="before_filter_name" v-bind:filter_key="get_key(key)" v-bind:filter="filters[index1]"></slot>
                    <v-text-field
                        label="نام گروه فیلتر"
                        outlined
                        class="filter_input"
                        dense
                        hide-details
                        v-model="fields[key]"
                    >

                    </v-text-field>
                    <div @click="add_child_item(get_key(key))">
                        <v-icon style="margin-right:10px">mdi-plus</v-icon>
                    </div>
                </div>
                <div v-if="get_key(key)>0" class="remove-link" @click="removeFilterGroup(get_key(key))">
                    حذف فیلتر های {{ fields[key] }}
                </div>

            </div>

            <div style="width:100%;margin-bottom:15px" v-if="childField[get_key(key)]!=undefined">

                <div v-for="(key2,index2) in Object.keys(childField[get_key(key)])" class="child-input-list"
                     draggable="true"
                     @dragstart="childDragStart(get_key(key),index2)"
                     @drop="childDrop(get_key(key),index2)"
                     @dragover.prevent
                >
                    <v-text-field
                        label="عنوان فیلتر"
                        outlined
                        class="child_input_item"
                        dense
                        hide-details
                        v-model="childField[get_key(key)][key2]"
                    >

                    </v-text-field>

                    <div v-if="get_key(key2)>0" class="remove-link" @click="removeFilter(get_key(key2))">
                        حذف فیلتر
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
        name: "CatFilters",
        props:['filters','cat_id'],
        data(){
            return {
                fields:{},
                childField:{},
                remove_key:0,
                dialog:false,
                msg:'',
                startDragRow:0,
                startDragChildKey:0,
                startDragChild:0,
                formData:{}
            }
        },
        mounted() {
            if(this.filters.length===0){
                this.fields=Object.assign(this.fields,{"-1":''});
            }
            else{
                for (let i = 0; i <this.filters.length ; i++) {
                    const key=this.filters[i]['id'];
                    this.fields=Object.assign(this.fields,{[i+"_"+key]:this.filters[i]['title']});

                    for (let j = 0; j <this.filters[i]['get_child'].length ; j++) {
                        const id=this.filters[i]['get_child'][j]['id'];
                        const value=this.filters[i]['get_child'][j]['title'];
                        if(this.childField[key]===undefined){
                            this.childField=Object.assign(this.childField,{[key]:{[i+"_"+id]:value}});
                        }
                        else{
                            const newData=Object.assign(this.childField[key],{[i+"_"+id]:value});
                            this.childField[key]=newData;
                        }
                    }
                }
            }
            this.$forceUpdate();

            this.$root.$on('filter_complete_data',(key,value,dataName)=>{
                if(this.formData[dataName]===undefined){
                    this.formData[dataName]={[key]:value};
                }
                else {
                    this.formData[dataName]=Object.assign( this.formData[dataName],{[key]:value});
                }
            });
        },
        methods:{
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
            removeFilterGroup:function (key) {
                this.remove_key=key;
                this.msg='آیا از حذف این فیلتر ها مطمئن هستین ؟';
                this.dialog=true;
            },
            addNewGroup:function () {
                const id = document.getElementsByClassName('filter_input').length + 1;
                const key="-"+id;
                this.fields=Object.assign(this.fields,{[key]:''});
                this.$forceUpdate();
            },
            send_data:async function (){
                const url=this.$siteUrl+'/admin/category/'+this.cat_id+'/filters';

                this.formData['filter']=this.fields;
                this.formData['child_filter']=this.childField;
                await this.$root.$emit('before_send_data');
                const self=this;
                setTimeout(function () {
                    self.$root.$emit('send_post_request',url,self.formData);
                },50);
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
            removeFilter:function (key) {
                this.remove_key=key;
                this.msg='آیا از حذف این فیلتر مطمئن هستین ؟';
                this.dialog=true;
            },
            add_child_item:function (key) {
                const id = -(document.getElementsByClassName('child_input_item').length + 1);
                if(this.childField[key]===undefined){
                    this.childField=Object.assign(this.childField,{[key]:{[id]:''}});
                }
                else{
                    const newData=Object.assign(this.childField[key],{[id]:''});
                    this.childField[key]=newData;
                }

                this.$forceUpdate();
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
            sendRequest:function () {
                const url=this.$siteUrl+"/admin/category/filters/"+this.remove_key;
                this.$root.$emit('send_delete_request',url);
                this.dialog=false;
            },
        }
    }
</script>

<style scoped>
    .item_input{
        max-width:300px;
    }
    .items-row{
        width:100%;
        margin-bottom:20px;
        background-color: rgba(250, 249, 249, 0.99);
        padding:15px;
    }
    .child-input-list{
        display: flex;
        align-items: center;
    }
    .child_input_item{
        max-width:300px;
        margin-top:15px;
    }
    .remove-link{
        color:red;
        cursor: pointer;
        font-size:15px;
        padding-right:10px;
    }
    .filter_input{
        min-width:300px
    }
</style>
