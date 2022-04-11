<template>
    <div>
        <v-checkbox label="مقایسه"
                    @change="$root.$emit('compare-event',id,title,image_url)"
        v-model="select"
        ></v-checkbox>
    </div>
</template>

<script>
export default {
    name: "ComparisonCheckbox",
    props:['id','title','image_url'],
    data(){
        return {
            select:null
        }
    },
    mounted() {
        this.$root.$on('remove_product_of_compare_list',(p_id)=>{
            if(p_id===this.id){
                this.select=null;
            }
        });
    }
}
</script>

