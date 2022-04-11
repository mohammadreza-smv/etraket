<template>
      <div>

          <div v-for="item in product_items" :key="item.id" class="item_groups" style="margin-bottom:20px">

              <p class="item-title">{{ item.title }}</p>


              <div v-for="childItem in item.get_child" :key="childItem.id">


                  <div v-for="(i,key) in itemValue[childItem.id]" style="width:100%;display: flex">

                      <v-text-field
                          outlined
                          :label="childItem.title "
                          dense
                          v-model="itemValue[childItem.id][key]"
                      >

                      </v-text-field>

                      <slot name="after_input"  v-bind:item="childItem" v-if="key===0"></slot>

                  </div>

              </div>

          </div>

          <v-btn v-if="product_items.length>0" color="success" @click="send_data()">
              ثبت اطلاعات
          </v-btn>
      </div>
</template>

<script>
    export default {
        name: "AddProductItems",
        props:['product_items','product_id','route_param'],
        data(){
            return {
                itemValue:{},
                formData:{}
            }
        },
        mounted() {
            for (let i = 0; i <this.product_items.length ; i++) {
                for (let j = 0; j <this.product_items[i]['get_child'].length ; j++) {

                    if(this.product_items[i]['get_child'][j].get_value.length>0){
                        for (let k = 0; k <this.product_items[i]['get_child'][j].get_value.length; k++) {
                            if(this.itemValue[this.product_items[i]['get_child'][j].id]===undefined){
                                this.itemValue[this.product_items[i]['get_child'][j].id]=[
                                    this.product_items[i]['get_child'][j].get_value[k].item_value
                                ];
                            }
                            else{
                                this.itemValue[this.product_items[i]['get_child'][j].id].push(
                                    this.product_items[i]['get_child'][j].get_value[k].item_value
                                );
                            }
                        }
                    }
                    else{
                        this.itemValue[this.product_items[i]['get_child'][j].id]=[''];
                    }
                }
            }
            this.$forceUpdate();

            this.$root.$on('add_new_item_input',(id)=>{
                this.itemValue[id].push('');
                this.$forceUpdate();
            })

            this.$root.$on('change_default_item_value',(id,title,status,fieldName,fieldValue)=>{
                if( this.itemValue[id][0]!==undefined){
                    if(status){
                        this.itemValue[id][0]=this.itemValue[id][0]+title+',';
                    }
                    else{
                        this.itemValue[id][0]=this.itemValue[id][0].toString().replace(title+',','');
                    }

                    if(fieldName!==undefined && fieldValue!==undefined){
                        if(this.formData[fieldName]===undefined){
                            this.formData[fieldName]=fieldValue;
                        }
                        else{
                            this.formData[fieldName]=Object.assign(this.formData[fieldName],fieldValue);
                        }
                    }
                    this.$forceUpdate();
                }
            });
        },
        methods:{
            send_data:function () {
                const url=this.$siteUrl+"/"+this.route_param+"/products/"+this.product_id+"/items";
                this.formData['item_value']=this.itemValue;
                this.$root.$emit('send_post_request',url,this.formData);
            }
        }
    }
</script>

<style scoped>
    .item_groups{
        padding:15px;
        background:#f8fafc;
        border-radius:4px;
        -webkit-border-radius:4px;
    }
</style>
