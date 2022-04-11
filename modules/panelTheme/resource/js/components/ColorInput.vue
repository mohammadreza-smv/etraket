<template>
    <div :class="className">
        <v-text-field
            v-model="input"
            outlined
            :rules="rules"
            :label="label!=='false' ? label : ''"
            dense
        >
            <template v-slot:append>
                <v-menu v-model="menu" :close-on-content-click="false">
                    <template v-slot:activator="{ on }">
                        <div :style="swatchStyle" v-on="on" />
                    </template>
                    <v-card>
                        <v-card-text class="pa-0">
                            <v-color-picker v-model="input" flat />
                        </v-card-text>
                    </v-card>
                </v-menu>
            </template>
        </v-text-field>
        <input type="hidden" :name="name" v-model="input.toString().replace('#','')">
    </div>
</template>

<script>
    export default {
        name: "ColorInput",
        props:['value','label','name','args'],
        data(){
            return {
                input:'',
                menu: false,
                className:'c-field',
                rules:[],
            }
        },
        mounted() {
            if(this.value!==''){
                this.input='#'+this.value;
            }
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
        computed: {
            swatchStyle() {
                const { input, menu } = this
                return {
                    backgroundColor: input,
                    cursor: 'pointer',
                    height: '30px',
                    width: '30px',
                    borderRadius: menu ? '50%' : '4px',
                    transition: 'border-radius 200ms ease-in-out',
                    border:'1px solid rgba(187, 187, 187, 0.38)',
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
