<template>

    <div>

        <v-tooltip left>

            <template v-slot:activator="{ on }">
                <div  v-on="on" @click="getData()">
                    <v-icon>
                        mdi-chart-line
                    </v-icon>
                </div>

            </template>
            <span>تغییرات قیمت</span>

        </v-tooltip>

        <v-dialog
            v-model="dialog"
            width="850"
        >

            <v-card class="price-chart">

                <v-card-title class="headline lighten-2">
                    <h5> نمودار تغییرات قیمت</h5>

                    <v-icon @click="dialog=false">mdi-close</v-icon>

                </v-card-title>

                <v-card-text>

                    <div v-if="sendRequest" class="progress-box">


                        <div style="width:50%">
                            <v-progress-linear
                                color="blue accent-4"
                                indeterminate
                                rounded
                                height="6"
                            ></v-progress-linear>
                        </div>

                    </div>

                    <div v-else>
                        <div v-if="this.chartOptions.series.length>0">
                            <div class="chart-box">
                                <highcharts :options="chartOptions"></highcharts>
                            </div>
                            <div class="chart_color_div">
                                <ul class="color_ul">
                                    <li v-for="(item,key) in param1" v-bind:class="[color_key==key ? 'color_li active' : 'color_li']" v-bind:key="key">
                                        <label v-on:click="change_series(key)">
                                            <span v-if="item.code!=undefined" class="ui_variant_shape" v-bind:style="{background:'#'+item.code}"></span>
                                            <span v-else class="ui_variant_shape">{{ item.name}}</span>
                                            <span class="color_name" :style="{paddingRight:item.code!=undefined ? '20px' : '5px'}">{{ item.name }}</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div v-else style="height: 400px;display: flex;justify-content: center;align-items: center">
                            <span>تغییرات قیمت طی یک ماه گذشته برای این محصول ثبت نشده</span>
                        </div>
                    </div>

                </v-card-text>

            </v-card>

        </v-dialog>
    </div>

</template>

<script>
    import {Chart} from 'highcharts-vue';
    import methods from "../methods";
    export default {
        name: "VueChart",
        mixins:[methods],
        data(){
           const self=this;
           return{
               dialog:false,
               chartOptions: {
                   series: [],
                   title:{
                       text:'',
                       update:true
                   },
                   xAxis:{
                       categories:[]
                   },
                   chart:{
                       height:400,
                       type:'line',
                       style:{
                           fontFamily:'IRANSansWeb'
                       }
                   },
                   yAxis:{
                       title:{
                           text:''
                       },
                       labels:{
                           useHTML:true,
                           formatter:function(){
                               let value=self.replaceNumber(self.number_format(this.value));
                               return '<div style="direction: rtl"> <span>'+value+'</span> <span style="padding-right: 2px">تومان</span> </div>'
                           },
                           style:{
                               fontSize:'13px'
                           }
                       }
                   },
                   tooltip:{
                       backgroundColor:'#fff',
                       borderColor:'#c8c8c8',
                       borderRadius:10,
                       borderWidth:1,
                       useHTML:true,
                       formatter:function(){
                           if(this.point.has_product=="ok")
                           {
                               return '<div>' +
                                   '<ul class="chart_ul">' +
                                   '<li style="justify-content: end;margin-top: 10px">' +
                                   '<span style="padding-right: 4px">'+this.point.seller+'</span> : <span>فروشنده</span>' +
                                   '</li>' +
                                   '<li style="justify-content: space-between;margin-top: 15px">' +
                                   '<div style="color:#00bfd6;font-size:19px;direction: rtl"><span>'+self.replaceNumber(self.number_format(this.point.price))+'</span> <span>تومان</span></div>' +
                                   '<div>کمترین قیمت</div>' +
                                   '</li>' +
                                   '</ul>' +
                                   '</div>';
                           }
                           else{
                               return '<div>' +
                                   '<ul class="chart_ul">' +
                                   '<li style="justify-content: space-between;margin-top: 15px">' +
                                   '<div style="color:#00bfd6;font-size:19px;direction: rtl"><span>ناموجود</span></div>' +
                                   '<div>کمترین قیمت</div>' +
                                   '</li>' +
                                   '</ul>' +
                                   '</div>';
                           }
                       }
                   }
               },
               param1:[],
               color_key:0,
               paramName:'',
               sendRequest:true
           }
        },
        components: {
            highcharts: Chart
        },
        props:['product_id'],
        mounted() {
            const app=this;
            $(document).on('click','#price-chart',function () {
                app.getData();
            });
        },
        methods:{
            getData()
            {
                this.dialog=!this.dialog;
                if(this.chartOptions.series.length==0)
                {
                    const app=this;
                    const url=this.$siteUrl+'/chart/price-changes-detail/'+this.product_id;
                    this.axios.get(url).then(response=>{
                        this.chartOptions['xAxis']['categories']=response.data.points;
                        this.param1=response.data.param1;
                        let i=0;
                        response.data.price.forEach(function (item) {
                            let name=response.data.param1[i].name;
                            const zonesRow=response.data.zone[response.data.param1[i].id];
                            app.chartOptions['series'].push({'data':item,'name':name,'color':'#00bfd6',marker:{symbol:'circle'},zones:zonesRow,zoneAxis:'x'});
                            if(i>0)
                            {
                                app.chartOptions['series'][i].visible=false;
                            }
                            else {
                                app.chartOptions['series'][i].visible=true;
                            }
                            i++;
                        });
                        this.paramName=response.data.paramName;
                        this.sendRequest=false;
                    }).catch(error=>{
                        this.sendRequest=false;
                    });

                }
            },
            change_series:function(key){
                this.color_key=key;
                this.chartOptions['title']['update']=!this.chartOptions['title']['update'];
                this.chartOptions['series'].forEach(function (item) {
                    item.visible=false;
                });
                this.chartOptions['series'][key].visible=true;
            }
        }
    }
</script>

<style>
    .price-chart .v-card__title{
        display: flex;
        justify-content: space-between;
    }
    .price-chart h5{
        font-family: BYekan,sans-serif !important;
    }
    .progress-box{
        height:400px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .chart_color_div{
        height:50px;
        background: white;
        width: 100%;
        padding: 10px;
        position: relative;
        z-index: 100;
        margin-top: -50px;
    }
    .chart_color_div .color_name{
        padding-right:25px;
        padding-left:10px;
    }
    .chart_color_div .color_ul .active{
        border-color:#1ca2db !important;
    }
    .chart-box{
        width:97%;
        margin:30px auto 0px auto;
    }
</style>
