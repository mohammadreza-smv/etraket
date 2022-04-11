<template>
    <div class="input-group index_header_search">
        <input type="text" class="form-control" v-on:keyup.enter="search_product()" v-model='text' placeholder="نام کالا، برند و یا دسته مورد نظر خود را جستجو کنید…">
        <div class="input-group-prepend" v-on:click="search_product()">
            <div class="input-group-text">
                <span class="fa fa-search"></span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "HeaderSearch",
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

