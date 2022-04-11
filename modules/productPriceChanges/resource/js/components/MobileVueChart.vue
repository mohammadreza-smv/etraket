<template>
    <div>

        <transition name="data-box">
            <div v-if="show_box"  class="vue_mobile_data_box" >
                <div class="header">
                    <span>نمودار تغییرات قیمت</span>
                    <a v-on:click="hide_transition_box()">
                        <span>بازگشت</span>
                        <span class="fa fa-angle-left"></span>
                    </a>
                </div>

                <div>
                    <div v-if="this.chartOptions.series.length>0">
                        <div style="width:97%;margin:30px auto">
                            <highcharts :options="chartOptions"></highcharts>
                        </div>
                        <div class="chart_color_div">
                            <p>انتخاب {{ paramName }}</p>
                            <ul class="color_ul">
                                <li v-for="(item,key) in param1" v-bind:class="[color_key==key ? 'color_li active' : 'color_li']" v-bind:key="key">
                                    <label v-on:click="change_series(key)">
                                        <span class="color_name">{{ item.name }}</span>
                                    </label>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div v-else style="height: 400px;display: flex;justify-content: center;align-items: center">
                        <span>تغییرات قیمت طی یک ماه گذشته برای این محصول ثبت نشده</span>
                    </div>
                </div>

            </div>
        </transition>

    </div>
</template>

<script>
    import {Chart} from "highcharts-vue";
    import methods from "../methods";
    export default {
        mixins:[methods],
        name: "MobileVueChart",
        data(){
            return{
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
                        },
                        marginTop:25
                    },
                    yAxis:{
                        title:{
                            text:''
                        },
                        labels:{
                            useHTML:true,
                            formatter:function(){
                                let value=replaceNumber(number_format(this.value));
                                return '<div style="direction: rtl;color:gray" > ' +
                                    '<span>'+value+'</span> <span style="padding-right: 2px">تومان</span> </div>'
                            },
                            style:{
                                fontSize:'13px'
                            },
                            y:-10,
                            x:100
                        },
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
                                    '<div style="color:#00bfd6;font-size:19px;direction: rtl"><span>'+replaceNumber(number_format(this.point.price))+'</span> <span>تومان</span></div>' +
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
                show_box:false,
                paramName:''
            }
        },
        components: {
            highcharts: Chart
        },
        props:['product_id'],
        mounted() {
            const app=this;
            $(document).on('click','.fa-line-chart',function () {
                app.getData();
            });
        },
        methods:{
            getData()
            {
                if(this.chartOptions.series.length==0)
                {
                    $("#loading_box").show();
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
                        $("#loading_box").hide();
                        this.show_list_box();

                    }).catch(error=>{
                        $("#loading_box").hide();
                    });

                }
                else{
                    this.show_list_box();
                }
            },
            change_series:function(key){
                this.color_key=key;
                this.chartOptions['title']['update']=!this.chartOptions['title']['update'];
                this.chartOptions['series'].forEach(function (item) {
                    item.visible=false;
                });
                this.chartOptions['series'][key].visible=true;
            },
            show_list_box:function () {
                $('body').css('overflow-y','hidden');
                this.show_box=true;
            }
        }
    }
</script>


