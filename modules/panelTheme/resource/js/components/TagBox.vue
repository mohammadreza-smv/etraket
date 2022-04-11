<template>
    <div :class="className">
        <v-combobox multiple
                    v-model="select"
                    :label="label"
                    append-icon
                    chips
                    deletable-chips
                    class="tag-input"
                    :search-input.sync="search"
                    @keyup.tab="updateTags"
                    @paste="updateTags">
        </v-combobox>
        <input type="hidden" :name="name" v-model="select">
    </div>
</template>

<script>
    export default {
        name: "TagBox",
        props:['name','value','label','args'],
        data(){
            return {
                select: [],
                items: [],
                search: "",
                className:'',
            }
        },
        mounted() {
            if(this.value!==''){
                const tag=this.value.toString().split(',');
                for (let i = 0; i <tag.length ; i++) {
                    if(tag[i].toString().trim()!==''){
                        this.select.push(tag[i]);
                    }
                }
                this.$nextTick(() => {
                    this.search = "";
                });
            }

            if(this.args!=null){
                if(this.args['class']!==undefined){
                    this.className= this.className+' '+this.args['class'];
                }
            }
        },
        methods: {
            updateTags() {
                this.$nextTick(() => {
                    this.select.push(...this.search.split(","));
                    this.$nextTick(() => {
                        this.search = "";
                    });
                });
            }
        }
    }
</script>

<style >
    @import "../style.css";
</style>
