<template>
    <div>
        <v-slide-group
            multiple
            show-arrows
            class="order_steps"
        >
            <v-slide-item  v-for="(step,key) in steps" v-if="parseInt(step['value'])>-1" :key="key">

                <div class="swiper-slide">

                    <div :class="[ checkActiveStep(key) ? 'step_div step_inactive' : 'step_div']"
                         v-on:click="change_status(parseInt(step['value']))">

                        <img v-bind:src="$siteUrl+'/files/images/step'+parseInt(step['value'])+'.svg'" :style="[{width:'120px',height:'120px'}]" />
                        <span>{{ step['title']  }}</span>
                    </div>

                    <hr v-if="key!==(steps.length-1)"  :class="[key<=parseInt(activeKey) ? 'hr_active' : '' ]">

                    <div v-else style="min-width:66px"></div>

                </div>

            </v-slide-item>
        </v-slide-group>


        <v-dialog
            v-model="dialog"
            width="600"
            v-if="order_id!==undefined"
        >

            <v-card class="price-chart">

                <v-card-title class="headline lighten-2" style="display: flex;justify-content: space-between;">
                    <h5 style="font-family:inherit !important;">تغییر وضعیت مرسوله</h5>

                    <v-icon @click="dialog=false">mdi-close</v-icon>

                </v-card-title>

                <v-card-text>
                    آیا از تغییر وضعیت مرسوله به حالت {{ getStepTitle() }} مطمین هستین ؟

                    <div style="width:100%;margin:10px 0px">


                        <v-form ref="change_order_status" id="change_order_status">

                            <slot name="status_form"></slot>

                            <v-textarea class="c-field total-width"
                                        label="توضیحات"
                                        outlined
                                        v-model="tozihat"
                            ></v-textarea>

                            <input type="hidden" v-model="tozihat" name="tozihat">

                            <input type="hidden" :value="status" name="status">

                            <input type="hidden" :value="order_id" name="order_id">

                            <v-btn color="success" @click="sendRequest()">ثبت</v-btn>

                        </v-form>



                    </div>

                </v-card-text>

            </v-card>
        </v-dialog>

    </div>
</template>

<script>
    export default {
        name: "OrderStep",
        props:['steps','send_status','order_id'],
        data(){
           return{
               status:0,
               order_status:0,
               dialog:false,
               tozihat:'',
               activeKey:0
           }
        },
        mounted(){
            this.order_status=this.send_status;
            for (let i = 0; i <this.steps.length ; i++) {
                if(this.steps[i]['value']===parseInt(this.send_status)){
                    this.activeKey=i;
                }
            }
        },
        methods:{
            change_status:function (status) {
                this.tozihat='';
                this.status=status;
                this.dialog=true;
            },
            sendRequest:function () {
                this.dialog=false;

                let sendfile=false;
                const inputs=document.querySelectorAll('#change_order_status input');
                const formData=new FormData();
                for (let i = 0; i <inputs.length ; i++) {
                    const name=inputs[i].getAttribute('name');
                    if(name!==null){
                        let value=inputs[i].getAttribute('value');
                        if(inputs[i].getAttribute('type')==='file'){
                            value=inputs[i].files[0];
                            if(value!=null){
                                sendfile=true;
                                formData.append(name,value);
                            }
                        }
                        else{
                            formData.append(name,value);
                        }
                    }
                }

                let headers= {};
                if(sendfile){
                    headers={
                        'Content-Type': 'multipart/form-data'
                    };
                }
                const request_url=this.$siteUrl+'/admin/order/change_status';

                this.$root.$emit('send_post_request',request_url,formData,headers);

            },
            getStepTitle:function (){
                let title='';
                for (let i = 0; i <this.steps.length ; i++) {
                    if(this.steps[i].value===this.status){
                        title=this.steps[i]['title'];
                    }
                }
                return title;
            },
            checkActiveStep:function (key){
                let res=true;
                console.log(this.activeKey+'-'+key);
                if(key<=this.activeKey){
                    res=false;
                }
                return res;
            }
        }
    }
</script>

<style>
    @import "../style.css";
</style>
