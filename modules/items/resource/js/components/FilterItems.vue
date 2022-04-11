<template>
    <div style="margin-left: 10px" v-if="filter_key>0">
        <v-combobox
           v-model="select"
           :items="itemList"
           outlined
           dense
           item-value="title"
           item-text="title"
           return-object
           @input="change"
           class="filter_input"
          ></v-combobox>
    </div>
</template>

<script>
    export default {
        name: "FilterItems",
        props:['filter_key','items','filter'],
        data(){
            return {
                itemList:[],
                select:null,
                selectValue:null
            }
        },
        mounted() {
            this.setList();
            this.$root.$on('before_send_data',()=>{
                this.$root.$emit('filter_complete_data',this.filter_key,this.selectValue,'item_id');
            });
        },
        methods:{
            setList:function () {
                let newList=[];
                for (let i = 0; i <this.items.length ; i++) {
                    newList.push({
                        'id':this.items[i]['id'],
                        'title':this.items[i]['title']
                    });
                    console.log('1--'+this.filter['item_id']+'-'+this.items[i]['id']);
                    if(this.filter['item_id']===this.items[i]['id']){
                        this.select=this.items[i]['title'];
                    }

                    for (let j = 0; j <this.items[i]['get_child'].length ; j++) {
                        newList.push({
                            'id':this.items[i]['get_child'][j]['id'],
                            'title':"-"+this.items[i]['get_child'][j]['title']
                        });
                        if(this.filter['item_id']==this.items[i]['get_child'][j]['id']){
                            this.select="-"+this.items[i]['get_child'][j]['title'];
                        }
                    }
                }
                this.itemList=newList;
                if(this.filter['item_id']!==undefined){
                    this.selectValue=this.filter['item_id'];
                }
            },
            change:function (value) {
                this.selectValue=value['id'];
            },
        }
    }
</script>

<style scoped>
    .filter_input{
        min-width:300px
    }
</style>
