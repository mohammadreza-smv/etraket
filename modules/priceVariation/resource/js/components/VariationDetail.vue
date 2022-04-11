<template>

   <div>

       <v-card class="variation-detail">

           <div  v-if="slotName!=='default'" class="back-icon" @click="showDefaultSlot()">
               <v-icon size="25">mdi-arrow-right</v-icon>
               <span>{{ title }}</span>
           </div>

           <slot  :name="slotName"></slot>

           <div class="cart-btn-box">
               <v-btn color="error" dark large @click="add_product()">

                   <span v-if="send===false">افزودن به سبد خرید</span>

                   <v-progress-circular
                       indeterminate
                       color="white"
                       v-else
                   ></v-progress-circular>

               </v-btn>
           </div>
       </v-card>

       <v-dialog
           v-model="dialog"
           width="500"
       >

           <v-card>

               <v-card-text >

                   <div class="response-message" style="padding-top:30px">

                       <v-icon color="green" size="25">mdi-check</v-icon>

                       <span style="font-weight:600">محصول به سبد خرید شما اضافه شد</span>

                   </div>

               </v-card-text>

               <v-divider></v-divider>

               <v-card-actions>
                   <v-spacer></v-spacer>
                   <v-btn
                       color="primary"
                       text
                       @click="dialog = false"
                   >
                       بستن
                   </v-btn>
               </v-card-actions>
           </v-card>

       </v-dialog>

   </div>

</template>

<script>
    export default {
        name: "VariationDetail",
        props:['product_id'],
        data(){
           return {
               slotName:'default',
               title:'',
               send:false,
               dialog:false,
               sendRequest:true,
               other_param:[]
           }
        },
        mounted() {
            this.$root.$on('setSlot',(name,title)=>{
                this.slotName=name;
                this.title=title;
            });

            this.$root.$on('add_card_params',(object)=>{
                this.other_param.push(object);
            });

            this.$root.$on('update_variation',(elId)=>{
                if(this.sendRequest)
                {
                    const el=document.getElementById(elId);
                    if(el){

                        const formData={};

                        const param_id=el.getAttribute('data-param-id');
                        const param_type=el.getAttribute('data-param-type');
                        const param_key=el.getAttribute('data-param-key');
                        formData['change_num']=param_key;
                        if(param_key==='1'){
                            formData['param1']={'type':param_type,'id':param_id};
                            const variation_param2=document.getElementById('variation_param2');
                            if(variation_param2){
                                formData['param2']={
                                    'type':variation_param2.getAttribute('data-id'),
                                    'id':variation_param2.value};
                            }
                        }
                        else{
                            formData['param2']={'type':param_type,'id':param_id};
                            const variation_param1=document.getElementById('variation_param1');
                            if(variation_param1){
                                formData['param1']={
                                    'type':variation_param1.getAttribute('data-id'),
                                    'id':variation_param1.value};
                            }
                        }


                        formData['product_id']=this.product_id;

                        const url=this.$siteUrl+"/shop/change_product_variation";
                        this.sendRequest=false;
                        this.axios.post(url,formData).then(response=>{
                            this.sendRequest=true;
                            this.$el.remo
                            if(response.data['paramsView']!==undefined)
                            {
                                this.$root.$emit('update_variation_params',response.data['paramsView']);
                                this.$root.$emit('update_variation_detail',response.data['detailView']);
                            }
                        }).catch(error=>{
                            this.sendRequest=true;
                        });
                    }
                }
            });

            this.$root.$on('add_card_product',()=>{
                this.add_product();
            });
        },
        methods:{
            showDefaultSlot:function () {
                this.slotName='default';
                this.title='';
            },
            add_product:function () {
                const formData={};
                const variation_param1=document.getElementById('variation_param1');
                const variation_param2=document.getElementById('variation_param2');
                const variation_params={};
                formData['product_id']=this.product_id;
                if(variation_param1){
                    const v1=variation_param1.value;
                    const data_id1=variation_param1.getAttribute('data-id');
                    variation_params[data_id1+'\\param1']=v1;
                }

                if(variation_param2){
                    const v2=variation_param2.value;
                    const data_id2=variation_param2.getAttribute('data-id');
                    variation_params[data_id2+'\\param2']=v2;
                }
                formData['variation_params']=variation_params;

                if(this.other_param.length>0){

                    for (let i = 0; i <this.other_param.length ; i++) {
                        formData[this.other_param[i].key]=this.other_param[i].value;
                    }
                }

                const url=this.$siteUrl+"/Cart";
                this.send=true;
                if(this.sendRequest){
                    this.sendRequest=false;
                    this.axios.post(url,formData).then(response=>{
                        this.send=false;
                        this.sendRequest=true;
                        if(response.data.status==='ok'){
                            this.dialog=true;
                            this.$root.$emit('update-cart');
                        }
                    }).catch(error=>{
                        this.send=false;
                        this.sendRequest=true;
                    });
                }
            }
        },
        beforeDestroy() {
            this.$root.$off('update_variation')
        }
    }
</script>

<style scoped>
    @import "../../assets/style.css";
</style>
