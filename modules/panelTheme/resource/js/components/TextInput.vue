<template>
    <div :class="className">
        <v-text-field
            :label="label!=='false' ? label : ''"
            outlined
            :rules="rules"
            :dense="dense"
            :type="type"
            v-model="input"
            :prepend-inner-icon="prepend_icon"
        ></v-text-field>
        <input type="hidden" :name="name" v-model="input">
    </div>
</template>

<script>
    export default {
        name: "TextInput",
        props:['label','name','args','value','input_type','prepend_icon'],
        data(){
            return {
                options:[],
                rules:[],
                className:'c-field',
                type:'string',
                input:'',
                dense:true
            }
        },
        mounted() {
            if(this.input_type!==undefined){
                this.type=this.input_type;
            }

            this.input=this.value;
            if(this.value==='null'){
                this.input='';
            }
            if(this.args!=null){
                this.options=this.args;
                if(this.options['validate']!==undefined){
                   this.setValidate(this.options['validate']);
                }
                if(this.options['class']!==undefined){
                    this.className= this.className+' '+this.options['class'];
                }
                if(this.options['type']!==undefined){
                    this.type=this.options['type'];
                }

                if(this.args['dense']!==undefined){
                    this.dense=this.args['dense'];
                }
            }
        },
        methods:{
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
