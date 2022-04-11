<template>

    <div class="variation-item">
        <v-icon>mdi-home</v-icon>
        <a style="color:black" v-if="variation.seller.id!==0"
            @click="$root.$emit('send_get_request',baseUrl+'/seller/'+variation.seller.id)">
            <span>{{ variation.seller.brand_name }}</span>
        </a>
        <a v-else style="color:black">
            <span>{{ variation.seller.brand_name }}</span>
        </a>
    </div>

</template>

<script>
export default {
    name: "variation-list-param",
    props:['variation'],
    data(){
        return {
            baseUrl:''
        }
    },
    mounted() {
        this.baseUrl=this.$siteUrl;
    }
}
</script>

