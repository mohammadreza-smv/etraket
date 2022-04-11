<template>
    <div style="background-color: white">
        <slot name="header"></slot>
        <v-stepper alt-labels class="order-stepper"  v-model="e1">
            <v-stepper-header>

                <v-stepper-step step="1">
                    اطلاعات ارسال
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="2">
                    پرداخت
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="3">
                    اتمام خرید و ارسال
                </v-stepper-step>
            </v-stepper-header>
        </v-stepper>
    </div>
</template>

<script>
    export default {
        name: "OrderSteppers",
        props:['step'],
        data(){
            return {
                e1:'1'
            }
        },
        mounted() {
            if(this.step!==undefined){
                this.e1=this.step;
            }
        }
    }
</script>


