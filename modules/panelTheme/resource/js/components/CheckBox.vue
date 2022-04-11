<template>
    <div>
        <v-checkbox
            v-model="checkbox"
            :label="label"
        ></v-checkbox>
        <input type="hidden" v-model="checkbox" :name="name" v-if="checkbox">
    </div>
</template>

<script>
    export default {
        name: "CheckBox",
        props:['label','value','name'],
        data(){
            return {
                checkbox:null
            }
        },
        mounted() {
            this.checkbox=this.value;
            if(this.value==='0'){
                this.checkbox=false;
            }
        }
    }
</script>

