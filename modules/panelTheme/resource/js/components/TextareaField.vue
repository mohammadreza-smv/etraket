<template>
    <div :class="className">
        <v-textarea
            :label="label!=='false' ? label : ''"
            outlined
            :rules="rules"
            dense
            v-model="input"
        ></v-textarea>
        <input type="hidden" :name="name" v-model="input">
    </div>
</template>

<script>
    export default {
        name: "TextareaField",
        props:['label','name','args','value'],
        data(){
            return {
                options:[],
                rules:[],
                className:'c-field',
                type:'string',
                input:''
            }
        },
        mounted() {
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

