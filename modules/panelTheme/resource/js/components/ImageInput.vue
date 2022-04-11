<template>
    <div :class="className">

        <v-file-input
            v-model="file"
            :label="label"
            outlined
            dense
            accept="image/*"
            :name="name"
            @change="showImg"
            :rules="rules"
        ></v-file-input>

        <img :src="src" style="max-height:300px;margin: auto;display:table !important;max-width:100%;">

    </div>
</template>

<script>
    export default {
        name: "ImageInput",
        props:['label','name','default','args'],
        data(){
            return {
                src:'',
                file:null,
                className:"",
                options:[],
                rules:[],
            }
        },
        mounted() {
            this.src=this.default;
            if(this.args!=null){
                this.options=this.args;
                if(this.options['class']!==undefined){
                    this.className= this.className+' '+this.options['class'];
                }

                if(this.options['validate']!==undefined){
                    this.setValidate(this.options['validate']);
                }
            }
        },
        methods:{
            showImg:function (event) {
                if(this.file!=null){
                    this.src= URL.createObjectURL(this.file);
                }
                else{
                    this.src=null;
                }
            },
            setValidate:function (r) {
                r=r.toString().split('|');
                this.rules=[];
                for (let i = 0; i <r.length ; i++) {
                    if(r[i]==='required'){
                        this.rules[0]=v => !!v || ''+this.label+' نمی تواند خالی باشد';
                    }
                }
            }
        }
    }
</script>

<style>
    @import "../style.css";
</style>
