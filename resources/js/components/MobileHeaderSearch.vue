<template>
    <div class="input-group index_search_form">
        <input type="text" class="form-control" v-model='text' v-on:keyup.enter="search_product()"  placeholder="جست و جو میان بیش از ۱۰۰۰ کالا">
        <div class="input-group-prepend" v-on:click="search_product()">
            <div class="input-group-text">
                <span class="fa fa-search"></span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MobileHeaderSearch",
        data(){
            return {
                text:""
            }
        },
        methods:{
            search_product:function(){
                if(this.text.trim().length>=2){
                    window.location=this.$siteUrl+'/search?string='+this.text;
                }
            }
        }
    }
</script>

<style scoped>

</style>
