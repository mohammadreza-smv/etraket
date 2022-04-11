<template>
    <div style="display: flex;margin-top:20px" >

        <v-text-field
            v-model="text"
            solo
            dense
            placeholder="پرسش شما"
        >
        </v-text-field>

        <v-btn color="primary" @click="search()">
            جست و جو
        </v-btn>

    </div>
</template>

<script>
    export default {
        name: "FaqSearch",
        data(){
            return {
                text:''
            }
        },
        methods:{
            search:function () {
                if(this.text!==''){
                    const url=this.$siteUrl+"/faq?q="+this.text;
                    this.$root.$emit('send_get_request',url);
                }
            }
        }
    }
</script>


