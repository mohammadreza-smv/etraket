<template>
    <div>
        <div v-for="filter in product_filters" class="filter_groups">
            <p class="filter-title">{{ filter.title }}</p>

            <div v-for="child in filter.get_child">
                <v-checkbox
                  :label="child.title"
                  @change="change(filter.id,child.id)"
                  v-model="selected[child.id]"
                ></v-checkbox>
            </div>

        </div>

        <v-btn color="success" @click="send_data()">
            ثبت اطلاعات
        </v-btn>

    </div>
</template>

<script>
    export default {
        name: "AddProductFilters",
        props:['product_filters','product_id'],
        data(){
            return {
                selected:[],
                values:[]
            }
        },
        mounted() {
            const product_filters=this.product_filters;
            for (let i = 0; i <product_filters.length ; i++) {
                const values=product_filters[i].get_value;
                const id=product_filters[i]['id'];
                for (let j = 0; j <product_filters[i].get_child.length; j++) {
                    if(values[j]!==undefined){
                        const child_id=product_filters[i].get_child[j]['id'];
                        this.selected[child_id]=true;

                        if(this.values[id]===undefined){
                            this.values[id]=[child_id];
                        }
                        else{
                            this.values[id].push(child_id);
                        }
                    }
                }
            }
            this.$forceUpdate();
        },
        methods:{
            change:function (id,child_id) {
                 this.$nextTick(function () {
                     if(this.values[id]===undefined){
                         this.values[id]=[child_id];
                     }
                     else{
                         if(this.selected[child_id]==true)
                         {
                             this.values[id].push(child_id);
                         }
                         else{
                             for (let i = 0; i <this.values[id].length ; i++) {
                                 if(this.values[id][i]===child_id){
                                     delete this.values[id][i];
                                 }
                             }
                         }
                     }
                 });
            },
            send_data:function () {
                const url=this.$siteUrl+'/admin/products/'+this.product_id+'/filters';
                let formData={};
                formData['filter']=this.values;
                this.$root.$emit('send_post_request',url,formData);
            },
        }
    }
</script>

<style scoped>
    .filter_groups{
        padding:15px;
        background:#f8fafc;
        border-radius:4px;
        -webkit-border-radius:4px;
        margin-bottom:20px
    }
</style>
