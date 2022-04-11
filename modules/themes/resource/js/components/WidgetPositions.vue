<template>
    <div class="html-elements">


        <v-combobox
            v-model="$store.state.widget.positionName"
            item-value="id"
            :items="items"
            item-text="title"
            label="انتخاب موقعیت در قالب"
            outlined
            @change="change"
            return-object
        ></v-combobox>


        <div v-if="$store.state.widget.positionParam!==false" style="display: flex">

            <v-text-field
                dense
                :label="$store.state.widget.positionParamName"
                v-model="$store.state.widget.positionParam"
                outlined
            >

            </v-text-field>

            <v-btn
                 text
                 @click="setNewPosition"
                 color="success"
                 style="margin-right: 4px"
                >تایید
            </v-btn>

        </div>

    </div>
</template>

<script>
    export default {
        name: "WidgetPositions",
        computed:{
            items:function () {
                let items=[];
                const positions=this.$store.state.widget.positions;
                const keys=Object.keys(positions);
                if(keys.length>0){
                    for (let i = 0; i <keys.length; i++) {
                        const positionParam=positions[keys[i]].positionParam;
                        items.push({
                            title:positions[keys[i]].title,
                            id:keys[i],
                            positionParam:positionParam,
                            use_template:positions[keys[i]].use_template!==undefined ? positions[keys[i]].use_template : 'yes'
                        });
                    }
                }
                return items;
            }
        },
        methods:{
            change:function (obj) {
                this.$store.state.widget.position=obj.id;
                this.$store.state.widget.positionWithoutParam=obj.id;
                this.$store.state.widget.positionName=obj.title;
                this.$store.dispatch('widget/getPositionData');
                if(obj.positionParam!==undefined){
                    this.$store.state.widget.positionParamName=obj.positionParam;
                    this.$store.state.widget.positionParam='';
                }
                else{
                    this.$store.state.widget.positionParamName='';
                    this.$store.state.widget.positionParam=false;
                }
                if(obj.use_template!==undefined){
                    this.$store.state.widget.use_template=obj.use_template;
                }
                else{
                    this.$store.state.widget.use_template='yes';
                }
            },
            setNewPosition:function () {
                if(this.$store.state.widget.positionParam>0){
                    this.$store.state.widget.position=( this.$store.state.widget.positionWithoutParam+this.$store.state.widget.positionParam);
                    this.$store.dispatch('widget/getPositionData');
                }
                else if(this.$store.state.widget.positionParam===''){
                    this.$store.state.widget.position=this.$store.state.widget.positionWithoutParam;
                    this.$store.dispatch('widget/getPositionData');
                }
            }
        }
    }
</script>

<style scoped>
    select{
        margin-bottom: 20px;
    }
</style>
