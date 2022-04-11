<template>
    <div>

        <div v-if="showLoading"
             style="display:flex;align-items: center;justify-content: center;min-height:400px">
            <v-progress-circular
                indeterminate
                color="red"
            ></v-progress-circular>
        </div>

        <highcharts v-else :options="chartOptions"></highcharts>
    </div>
</template>

<script>
    import methods from "../methods";
    import {Chart} from "highcharts-vue";
    export default {
        name: "MonthSalesStatistics",
        data(){
            const app=this;
            return {
                chartOptions:{
                    chart:{
                        type:'line',
                        style:{
                            fontFamily:'IRANSansWeb'
                        }
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },
                    yAxis: {
                        title: {
                            text: ''
                        },
                        labels:{
                            useHTML:true,
                            formatter:function()
                            {
                                let value=this.value;
                                if(value>1000){
                                    value=app.number_format(value);
                                }
                                value=app.replaceNumber(value);
                                return '<div style="direction:ltr">'
                                    +'<span>'+value+'</span>'
                                    +'</div>';
                            },
                        },
                        style:{
                            fontSize:'15px'
                        }
                    },
                    legend: {
                        verticalAlign: 'top',
                        y:0
                    },
                    xAxis: {
                        categories:[]
                    },
                    series: [{
                        name: 'میزان فروش',
                        data: [],
                        color:'red'
                    },{
                        name: 'تعداد تراکنش',
                        data: [],
                        marker:{
                            symbol:'circle'
                        }
                    }],
                    tooltip:{
                        useHTML:true,
                        formatter:function()
                        {
                            if(this.series.name=='میزان فروش'){
                                return this.x+'<br>'+'<div style="padding:5px">'+this.series.name+' : '+app.replaceNumber(app.number_format(this.y))+' تومان'+'</div>';
                            }
                            else{
                                return this.x+'<br>'+'<div style="padding:5px">'+this.series.name+' : '+app.replaceNumber(app.number_format(this.y))+' بار'+'</div>';
                            }
                        },
                        style:{
                            fontSize:'15px'
                        }
                    },
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                },
                showLoading:false
            }
        },
        mixins:[methods],
        mounted() {
            this.getData();
        },
        components: {
            highcharts: Chart
        },
        methods:{
            getData()
            {
                const app=this;
                const url=this.$siteUrl+'/sellers/panel/get_month_sales_statistics';
                this.showLoading=true;
                this.axios.get(url).then(response=>{
                    this.chartOptions['series'][0]['data']=[];
                    this.chartOptions['series'][1]['data']=[];
                    let price=response.data.price_array;
                    let count=response.data.count_array;
                    this.chartOptions['xAxis']['categories']=response.data.date_list;
                    price.forEach(function(row){
                        app.chartOptions['series'][0]['data'].push(row);
                    });
                    count.forEach(function(row){
                        app.chartOptions['series'][1]['data'].push(row);
                    });

                    this.showLoading=false;
                }).catch((error)=>{
                    this.showLoading=false;
                });
            }
        }
    }
</script>

