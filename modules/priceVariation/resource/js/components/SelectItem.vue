<template>
    <div style="padding-top:10px;">

        <v-select
            outlined
            @change="change"
            item-value="title"
            item-text="title"
            return-object
            :items="items"
            dense
            v-model="select"
            style="width:250px"
            v-if="show"
        ></v-select>

        <input type="hidden"
               :id="'variation_'+param_key"
               :data-param-key="num"
               :data-param-type="v_type"
               :data-param-id="param_id"
        >

    </div>
</template>

<script>
    export default {
        name: "SelectItem",
        props:['price_variation','param_key','property','num','relation','select_id'],
        data(){
            return {
                items:[],
                addList:[],
                select:null,
                v_type:'',
                param_id:'',
                show:false
            }
        },
        mounted() {
            for (let i = 0; i <this.price_variation.length ; i++) {
                const p=this.price_variation[i];
                if(this.addList[p[this.property]]===undefined){
                    this.addList[p[this.property]]=p[this.property];
                    const param_id=(this.num=="1") ? p['param1_id'] : p['param2_id'];
                    this.items.push({
                        'id':p['id'],'title':p[this.relation].variation_value,
                        'param_id':param_id,
                        "v_type":p[this.param_key]
                    });
                    if(this.select_id==param_id){
                        this.select=p[this.relation].variation_value;
                    }
                }
            }
            this.$nextTick(function () {
                this.show=true;
            });
        },
        methods:{
            change:function (val) {
                this.v_type=val['v_type'];
                this.param_id=val['param_id'];
                this.$nextTick(function () {
                    this.$root.$emit('update_variation','variation_'+this.param_key);
                });
            }
        }
    }
</script>


