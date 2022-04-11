<template>

    <div  :class="className">
        <v-combobox
            v-model="select"
            :items="items"
            :label="label"
            outlined
            :dense="dense"
            item-value="title"
            item-text="title"
            return-object
            @input="change"
            item-color="white"
            class="c-combobox"
            :prepend-inner-icon="prepend_icon"
            :rules="rules"
        >
        </v-combobox>

        <input type="hidden" :name="name" :value="inputValue">
    </div>

</template>

<script>
    export default {
        name: "Combobox",
        props:['label','name','args','list','value','prepend_icon'],
        data(){
            return {
                select:null,
                items:[],
                inputValue:'',
                className:'c-field',
                options:[],
                dense:false,
                rules:[]
            }
        },
        mounted() {

            if(this.args!=null){
                this.options=this.args;
                if(this.options['class']!==undefined){
                    this.className= this.className+' '+this.options['class'];
                }

                if(this.args['dense']!==undefined){
                    this.dense=this.args['dense'];
                }

                if(this.options['validate']!==undefined){
                    this.setValidate(this.options['validate']);
                }
            }

            this.setList();

        },
        methods:{
            change:function (value) {
                this.inputValue=value['id'];
            },
            setList:function () {
                const keys=Object.keys(this.list);
                let newList=[];
                for (let i = 0; i <keys.length ; i++) {
                    newList.push({
                        'id':keys[i],
                        'title':this.list[keys[i]]
                    });
                    if(keys[i]===this.value){
                        this.select=this.list[keys[i]];
                    }
                }
                this.items=newList;
                this.inputValue=this.value;
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

