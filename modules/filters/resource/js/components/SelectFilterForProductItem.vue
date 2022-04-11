<template>
    <div style="width:60px;margin-right:10px;margin-left:10px">
        <v-menu offset-y v-if="filter_array[item.id]!==undefined">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="primary"
                    dark
                    v-bind="attrs"
                    v-on="on"
                >
                    انتخاب
                </v-btn>
            </template>
            <v-list v-if="filters[filter_array[item.id]]!==undefined">

                <v-list-item
                    v-for="(item, index) in filters[filter_array[item.id]].get_child"
                    :key="index"
                >
                    <v-checkbox
                       :label="item.title"
                       @change="change(item.title,index)"
                       v-model="checkbox[index]"
                      >

                    </v-checkbox>
                </v-list-item>

            </v-list>
        </v-menu>
        <div v-else>
            <component :is="default_component" :item="item"/>
        </div>

    </div>
</template>

<script>
    export default {
        name: "SelectFilterForProductItem",
        props:['item','default_component','filter_array','filters','product_filters'],
        data(){
            return {
                checkbox: {},
                fieldValue:''
            }
        },
        mounted() {
            if(this.filter_array[this.item.id]!==undefined && this.filters[this.filter_array[this.item.id]]!==undefined){
                const child=this.filters[this.filter_array[this.item.id]].get_child;
                for (let i = 0; i <child.length; i++) {
                    if(this.product_filters[child[i].id]!==undefined){
                        this.checkbox[i]=true;
                    }
                }
            }
        },
        methods:{
            change:function (title,index) {
                const fieldName='filter_value['+this.item.id+']['+this.filters[this.filter_array[this.item.id]].id+']';
                if(this.checkbox[index]){
                    this.fieldValue=this.fieldValue+this.filters[this.filter_array[this.item.id]].get_child[index].id+'@';
                }
                else{
                    this.fieldValue= this.fieldValue.toString().replace(this.filters[this.filter_array[this.item.id]].get_child[index].id+'@','');
                }
                const fieldValue={[this.item.id]:{[this.filters[this.filter_array[this.item.id]].id]:this.fieldValue}};
                this.$root.$emit('change_default_item_value',
                    this.item.id,title,this.checkbox[index],'filter_value',fieldValue);
            }
        }
    }
</script>

