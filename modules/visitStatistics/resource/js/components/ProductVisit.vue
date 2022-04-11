<template>


    <div>

        <div v-if="send_request" class="progress-box"
             style="min-height:400px;display:flex;align-items: center;justify-content: center">
            <v-progress-circular
                indeterminate
                color="red"
            ></v-progress-circular>
        </div>

        <div v-else>

            <div style="display: flex;width: 320px">

                <v-select
                    label="سال"
                    v-model="year"
                    :items="years"
                    outlined
                    style="width:150px;margin-left:20px"
                    dense
                    @change="setYear"
                    item-color="white"
                ></v-select>

                <v-select
                    :items="months"
                    label="ماه"
                    outlined
                    dense
                    style="width: 150px"
                    v-model="mseelcct"
                    item-color="white"
                    @change="changeMonth"
                ></v-select>

            </div>

            <highcharts :options="chartOptions"></highcharts>

        </div>

    </div>
</template>

<script>
import methods from "../methods";
import {Chart} from 'highcharts-vue';
export default {
    name: "ProductVisit",
    mixins:[methods],
    props:['product_id'],
    data(){
        const app=this;
        return {
            month:'',
            year:'',
            send_request:true,
            years:[],
            chartOptions:{
                title: {
                    text: ''
                },
                chart:{
                    type:'line',
                    style:{
                        fontFamily:'inherit'
                    }
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
                        style:{
                            fontSize:'15px'
                        }
                    }
                },
                xAxis: {
                    categories:[]
                },
                legend: {
                    verticalAlign: 'top',
                    y:0
                },
                series: [{
                    name: 'بازدید یکتا',
                    data: [],
                    color:'red'
                },{
                    name: 'بازدید کل',
                    data: [],
                    marker:{
                        symbol:'circle'
                    }
                },{
                    name: 'ورودی گوگل',
                    data: [],
                    marker:{
                        symbol:'circle'
                    }
                }],
                tooltip:{
                    useHTML:true,
                    formatter:function()
                    {
                        if(this.series.name=='بازدید یکتا'){
                            return this.x+'<br>'+'<div style="padding:5px">'+this.series.name+' : '+app.replaceNumber(app.number_format(this.y))+'</div>';
                        }
                        else{
                            return this.x+'<br>'+'<div style="padding:5px">'+this.series.name+' : '+app.replaceNumber(app.number_format(this.y))+'</div>';

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
            months:[
                'فروردین',
                'اردیبهشت',
                'خرداد',
                'تیر',
                'مرداد',
                'شهریور',
                'مهر',
                'آبان',
                'آذر',
                'دی',
                'بهمن',
                'اسفند'
            ],
            mseelcct:null
        }
    },
    components: {
        highcharts: Chart
    },
    mounted() {
        this.getData();
    },
    methods:{
        getData:function (){
            this.send_request=true;
            let url=this.$siteUrl+'/admin/statistics/product/'+this.product_id+'/visit';
            if(this.month!==''){
                url=url+'?month='+this.month;
            }
            if(this.year!==''){
                url=url+'&year='+this.year;
            }
            this.axios.get(url).then(response=>{
                this.send_request=false;
                const categories=[];
                for (let i = 1; i <=Object.keys(response.data['unique_visit']).length ; i++) {
                     categories.push(i);
                }
                this.chartOptions['xAxis']['categories']=categories;
                this.chartOptions.series[0]['data']=response.data['unique_visit'];
                this.chartOptions.series[1]['data']=response.data['view'];
                this.chartOptions.series[2]['data']=response.data['google_visit'];
                this.years=response.data.years;
                this.year=response.data.year;
                this.month=response.data.month;
                for (let i = 0; i <this.months.length ; i++) {
                    if(i===(response.data.month-1)){
                        this.mseelcct=this.months[i];
                    }
                }
            }).catch((error)=>{
                this.send_request=false;
            });
        },
        changeMonth:function (value){
            for (let i = 0; i <this.months.length ; i++) {
                if(this.months[i]===value){
                    this.month=(i+1);
                    this.getData();
                }
            }
        },
        setYear:function (value){
            this.year=value;
            this.getData();
        }
    }
}
</script>


