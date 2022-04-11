<template>
    <div class="header-search">
        <v-text-field
            placeholder="جست و جو در سایت"
            filled
            hide-details
            clearable
            prepend-inner-icon="mdi-magnify"
            v-model="text"
            v-on:keyup.enter="onEnter"
        >
        </v-text-field>

    </div>
</template>

<script>
    export default {
        name: "header-search",
        data(){
            return {
                text:''
            }
        },
        methods:{
            onEnter:function () {
                if(this.text.trim().length>=2){
                    const url=this.$siteUrl+'/search?string='+this.text;
                    this.$root.$emit('send_get_request',url);
                }
            }
        }
    }
</script>

<style>
    .header-search{
        width:55%;
        margin-right:40px;
        margin-top:20px;
    }
    .header-search .v-text-field > .v-input__control > .v-input__slot::before{
        border: none !important;
    }
    .header-search .v-text-field > .v-input__control > .v-input__slot::after{
        border: none !important;
    }
    .header-search .v-text-field--filled{
        border-radius:5px !important;
        -webkit-border-radius:5px !important;
    }
    .header-search .v-icon.primary--text{
        color: black !important;
        caret-color: black !important;
    }
</style>
