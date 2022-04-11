<template>
    <div>

        <v-card :disabled="send" style="background-color:transparent" elevation="0">

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
                    @input="sendActiveCode"
                    v-model="activeCode"
                >

                </v-text-field>

            </v-row>

            <v-row>

                <div id="resend_active_code" style="display: flex;padding-bottom:20px">
                    <span @click="resend_active_code()" style="cursor:pointer;font-weight:bold;">ارسال مجدد کد</span>

                    <div class="c-counter" style="padding-right:10px" v-if="show_second>0">
                        <span>{{ h }}</span>:<span>{{ m }}</span>:<span>{{ s }}</span>
                    </div>
                </div>

            </v-row>

            <v-snackbar
                v-model="serverError"
            >
               {{ serverError }}
            </v-snackbar>


        </v-card>

    </div>
</template>

<script>
    import methods from "../methods";
    export default {
        name: "RegisterActiveCode",
        props:['mobile'],
        mixins:[methods],
        data(){
            return {
                activeCode:'',
                h:'',
                m:'',
                s:'',
                show_second:0,
                timer:null,
                resend:true,
                serverError:false,
                send:false
            }
        },
        mounted() {
             this.$root.$on('seller_register_step3',()=>{
                 this.show_second=180;
                 this.counter();
                 this.timer=setInterval(this.counter,1000);
             });
        },
        beforeDestroy() {
            if(this.timer!==null){
                clearInterval(this.timer);
            }
        }
    }
</script>

