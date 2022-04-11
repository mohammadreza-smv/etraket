<template>
     <div>

         <slot name="step1" v-if="step===1"></slot>

         <v-card v-if="step===2" style="background-color:transparent;max-width:400px;margin: auto" elevation="0" >

             <v-row>

                 <v-alert type="success" style="width:100%">
                     <span>به شماره موبایل {{ replaceNumber(mobile) }} کد تایید ارسال شد</span>
                 </v-alert>

             </v-row>

             <v-row>

                 <v-text-field
                     class="register-active-code"
                     autofocus
                     outlined
                     @input="sendProfileActiveCode"
                     v-model="activeCode"
                 >

                 </v-text-field>

             </v-row>

         </v-card>

     </div>
</template>

<script>
    import methods from "../methods";

    export default {
        name: "Profile",
        mixins:[methods],
        data(){
            return {
                step:1,
                encrypted:'',
                activeCode:'',
                mobile:''
            }
        },
        mounted() {
            this.step=1;
            this.$root.$on('hide_progress',(data)=>{
                if(data!==undefined){
                    if(data['status']==='active_mobile'){
                        this.step=2;
                        this.encrypted=data['encrypted'];
                        this.mobile=data['mobile'];
                    }
                    else if(data['status']==='ok'){
                        this.step=1;
                    }
                }
            });
        }
    }
</script>

