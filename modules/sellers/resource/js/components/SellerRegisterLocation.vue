<template>
    <v-row :class="rowClassName">

        <div class="c-combobox" style="padding-left: 5px;width:50%">
            <v-combobox
                v-model="select1"
                :items="provinces"
                label="استان"
                outlined
                item-value="title"
                item-text="title"
                return-object
                @input="change"
                item-color="white"
                :rules="provinceRules"
            >
            </v-combobox>

            <input type="hidden" name="province_id" :value="province">
        </div>

        <div class="c-combobox" style="padding-right: 5px;width:50%">
            <v-combobox
                v-model="select2"
                :items="cites"
                label="شهر"
                outlined
                item-value="title"
                item-text="title"
                return-object
                @input="change2"
                item-color="white"
                :rules="cityRules"
            >
            </v-combobox>

            <input type="hidden" name="city_id" :value="city">
        </div>

    </v-row>
</template>

<script>
    export default {
        name: "SellerRegisterLocation",
        data(){
            return {
                provinces:[],
                cites:[],
                province:'',
                select1:'',
                provinceRules: [
                    v => !!v || 'استان نمیتواند خالی باشد',
                ],
                city:'',
                select2:'',
                cityRules: [
                    v => !!v || 'شهر نمیتواند خالی باشد',
                ],
                rowClassName:''
            }
        },
        mounted() {
            this.getProvinceList();
            if(this.class_name!==undefined){
                this.rowClassName=this.class_name;
            }
        },
        methods:{
            getProvinceList:function () {
                const url=this.$siteUrl+'/api/app/provinces';
                this.axios.get(url).then(response=>{
                    for (let i = 0; i <response.data.original.length ; i++) {
                        const p=response.data.original[i];
                        this.provinces.push({'title':p.name,'id':p.id})
                        if(this.province_id!==undefined && p.id==this.province_id){
                            this.select1={'title':p.name,'id':p.id};
                            this.province=this.province_id;
                            this.getCityList();
                        }
                    }

                });
            },
            change:function (value) {
                this.province=value['id'];
                this.getCityList();
            },
            change2:function (value) {
                this.city=value['id'];
            },
            getCityList:function () {
                this.cites=[];
                const url=this.$siteUrl+'/api/get_city/'+this.province;
                this.axios.get(url).then(response=>{
                    this.city='';
                    this.select2=null;
                    for (let i = 0; i <response.data.original.length ; i++) {
                        const p=response.data.original[i];
                        this.cites.push({'title':p.name,'id':p.id});
                        if(this.city_id!==undefined && p.id==this.city_id){
                            this.select2={'title':p.name,'id':p.id};
                            this.city=this.city_id;
                        }
                    }
                });
            }
        },
        props:['province_id','city_id','class_name']
    }
</script>

