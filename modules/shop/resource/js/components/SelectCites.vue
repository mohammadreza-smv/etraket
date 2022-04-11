<template>
    <div class="select-city-box">

        <div class="select-cites" @click="dialog=!dialog">
            <v-icon>mdi-map-marker-outline</v-icon>
            <span>{{ label }}</span>
        </div>


        <v-dialog
            v-model="dialog"
            width="450"
            content-class="select-cites-dialog"
        >
            <v-card>
                <v-card-title style="display: flex;justify-content: space-between">
                    <span>انتخاب شهر</span>
                    <div @click="dialog=!dialog">
                        <v-icon>mdi-close</v-icon>
                    </div>
                </v-card-title>
                <v-card-text style="padding-left: 0px !important;">
                    <div   v-if="cites.length>0" style="max-height:400px;overflow-y:auto" >
                        <v-list >
                            <v-list-item>
                                <template v-slot:default="{ active,}">
                                    <v-list-item-action>
                                        <v-checkbox
                                            v-model="selectAll"
                                            color="primary"
                                            :input-value="active"
                                            @change="selectAllEvent"
                                        ></v-checkbox>
                                    </v-list-item-action>

                                    <v-list-item-content>
                                        <v-list-item-title>همه شهر ها</v-list-item-title>
                                    </v-list-item-content>
                                </template>
                            </v-list-item>
                            <v-list-item-group multiple   v-model="settings" >
                                <v-list-item v-for="city in cites" :key="city.id">
                                    <template v-slot:default="{ active,}">
                                        <v-list-item-action>
                                            <v-checkbox
                                                :input-value="active"
                                                color="primary"
                                                @change="selectCityEvent"
                                            ></v-checkbox>
                                        </v-list-item-action>

                                        <v-list-item-content>
                                            <v-list-item-title>{{  city.name }}</v-list-item-title>
                                        </v-list-item-content>
                                    </template>
                                </v-list-item>

                            </v-list-item-group>
                        </v-list>
                    </div>


                    <div v-else style="height:150px;display: flex;align-items:center;justify-content: center">
                        <v-progress-circular indeterminate color="red"></v-progress-circular>
                    </div>

                    <div style="padding-left:24px">
                        <v-btn v-if="cites.length>0" color="error"  class="select-cites-btn"
                               @click="setCites">
                            تایید
                        </v-btn>
                    </div>

                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    name: "SelectCites",
    props:['selected'],
    data(){
        return {
            label:'انتخاب شهر',
            dialog:false,
            cites:[],
            settings: [],
            selectAll:false
        }
    },
    mounted() {
        this.getCityList();
    },
    methods:{
        getCityList:function (){
            this.axios.get(this.$siteUrl+'/api/seller/cities').then(response=>{
                this.cites=response.data.original;

                this.$nextTick(function (){
                    if(this.selected!=='null' && this.selected!==null && this.selected!=='all'){
                        const selectList=this.selected.toString().split('-');
                        if(selectList.length>0){
                            for (let i = 0; i <selectList.length ; i++) {
                                if(selectList[i]!==''){
                                    for (let j = 0; j <this.cites.length; j++) {
                                        if(this.cites[j].id==selectList[i]){
                                            this.settings.push(j);
                                        }
                                    }
                                }
                            }
                        }
                        this.setLabel();
                        this.$forceUpdate();
                    }
                    else if(this.selected==='all'){
                        this.selectAll=true;
                        for (let i = 0; i <this.cites.length ; i++) {
                            this.settings.push(i);
                        }
                        this.setLabel();
                        this.$forceUpdate();
                    }
                });

            }).catch(()=>{
                this.getCityList();
            });
        },
        selectAllEvent:function (){
            if(this.selectAll){
                this.settings=[];
                for (let i = 0; i <this.cites.length ; i++) {
                    this.settings.push(i);
                }
                this.$forceUpdate();
            }
            else {
                this.settings=[];
            }
        },
        selectCityEvent:function (){
            if(this.selectAll){
                this.selectAll=false;
            }
        },
        replaceNumber: function (n) {
            if (n != undefined) {
                n = n.toString();
                const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                for (let i = 0; i < find.length; i++) {
                    n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                }
                return n;
            }
        },
        setCites:function (){
             const url=this.$siteUrl+'/shop/set-shop-cites';
             this.dialog=false;
             if(this.settings.length>0){
                 let values='all';
                 if(this.settings.length>0 && this.settings.length!==this.cites.length){
                     values='';
                     for (let i = 0; i <this.settings.length ; i++) {
                         values=values+this.cites[this.settings[i]].id+'-';
                     }
                 }
                 this.$root.$emit('send_post_request',url,{cites:values});
             }
        },
        setLabel:function (){
            if(this.settings.length===1){
                this.label=this.cites[this.settings[0]].name;
            }
            else if(this.settings.length>1){
                if(this.settings.length===this.cites.length){
                    this.label='همه شهر ها';
                }
                else{
                    this.label=this.replaceNumber(this.settings.length)+' شهر';
                }
            }
            else{
                this.label='انتخاب شهر'
            }
        }
    }
}
</script>

<style>
@import "../../css/style.css";
</style>
