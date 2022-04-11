<template>
    <a>
        <v-tooltip left>

            <template v-slot:activator="{ on, attrs }">
                <div @click="addToList()">
                    <v-icon
                        :color="hasList==='' ? 'gray' : 'red'"
                        v-on="on"
                    >
                        mdi-heart-outline
                    </v-icon>
                </div>
            </template>
            <span>افزودن به علاقه مندی ها</span>

        </v-tooltip>
    </a>
</template>

<script>
    export default {
        name: "FavoriteShortCode",
        props:['favorite','product_id'],
        data(){
           return {
               hasList:''
           }
        },
        mounted() {
            this.hasList=this.favorite;
        },
        methods:{
            addToList:function () {
                const url=this.$siteUrl+"/user/add_favorite";
                this.$root.$emit('show_progress');
                this.axios.post(url,{'product_id':this.product_id}).then(response=>{
                    if(response.data==='ok'){
                        if(this.hasList===''){
                            this.hasList='ok';
                        }
                        else {
                            this.hasList='';
                        }
                    }
                    this.$root.$emit('hide_progress');
                }).catch(error=>{
                     if(error.response.status===401){
                         this.$root.$emit('show_desktop_login');
                     }
                    this.$root.$emit('hide_progress');
                });
            }
        }
    }
</script>

