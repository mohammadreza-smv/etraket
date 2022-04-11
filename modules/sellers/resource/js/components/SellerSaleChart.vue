<template>
    <div>
        <v-select
            label="سال"
            v-model="year"
            :items="years"
            outlined
            style="width:200px"
            dense
            @change="setYear"
        ></v-select>

        <highcharts :options="chartOptions"></highcharts>

        <div style="padding-top:50px">
            <highcharts :options="chartOptions2"></highcharts>
        </div>

    </div>
</template>

<script>
import {Chart} from 'highcharts-vue';
import methods from "../methods";
export default {
    name: "SellerSaleChart",
    props:['seller_id'],
    mixins:[methods],
    data(){
        const app=this;
        return{
            year:'',
            years:[],
            chartOptions: {
                series: [{
                    data:[],
                    color:'rgb(244,81,108)',
                    dataLabels:{
                        enabled:true,
                        color:'#FFFFFF',
                        formatter:function(){
                            return app.replaceNumber(app.number_format(this.y));
                        },
                        rotation:-90,
                        style:{
                            fontSize:'16px'
                        },
                        align:'right',
                        y:10
                    }
                }],
                legend:{
                    enabled:false,
                },
                title:{
                    text:'',
                    update:true
                },
                xAxis:{
                    type:'category'
                },
                chart:{
                    type:'column',
                    style:{
                        fontFamily:'inherit'
                    }
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
                            return '<div style="direction:rtl">'
                                +'<span>'+value+' تومان</span>'
                                +'</div>';
                        },
                        style:{
                            fontSize:'15px'
                        }
                    }
                },
                tooltip:{
                    useHTML:true,
                    formatter:function(){
                        return '<div style="width:210px;text-align:right">'+
                            '<p><span> میزان فروش در</span> '+ app.getMonthName((this.x+1))+' ماه</p>'+
                            '<div style="text-align:left;color:rgb(244,81,108);direction:rtl">'+
                            '<span>'+ app.replaceNumber(app.number_format(this.y)) +'</span>'+
                            '<span> تومان</span>'
                            +'</div>'
                            +'</div>';
                    },
                    style:{
                        fontSize:'16px'
                    }
                }
            },
            chartOptions2: {
                series: [{
                    data:[],
                    dataLabels:{
                        enabled:true,
                        color:'#FFFFFF',
                        formatter:function(){
                            return app.replaceNumber(app.number_format(this.y));
                        },
                        rotation:-90,
                        style:{
                            fontSize:'16px'
                        },
                        align:'right',
                        y:10
                    }
                }],
                legend:{
                    enabled:false,
                },
                title:{
                    text:'کمیسیون دریافت شده ',
                    update:true,
                },
                xAxis:{
                    type:'category'
                },
                chart:{
                    type:'column',
                    style:{
                        fontFamily:'IRANSansWeb'
                    }
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
                            return '<div style="direction:rtl">'
                                +'<span>'+value+' تومان</span>'
                                +'</div>';
                        },
                        style:{
                            fontSize:'15px'
                        }
                    }
                },
                tooltip:{
                    useHTML:true,
                    formatter:function(){
                        return '<div style="width:250px;text-align:right">'+
                            '<p><span> میزان دریافت کمیسیون در</span> '+ app.getMonthName((this.x+1))+' ماه</p>'+
                            '<div style="text-align:left;color:rgb(244,81,108);direction:rtl">'+
                            '<span>'+ app.replaceNumber(app.number_format(this.y)) +'</span>'+
                            '<span> تومان</span>'
                            +'</div>'
                            +'</div>';
                    },
                    style:{
                        fontSize:'16px'
                    }
                }
            },
            month:[
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
        }
    },
    components: {
        highcharts: Chart
    },
    mounted(){
        this.getData();
    },
    methods:{
        getData:function(){
            const app=this;
            let url=this.$siteUrl+'/admin/sellers/statistics/'+this.seller_id;
            if(this.year!==''){
                url=url+'/?year='+this.year;
            }
            this.$root.$emit('show_progress','');
            this.axios.get(url).then(response=>{
                this.$root.$emit('hide_progress','');
                this.chartOptions['series'][0]['data']=[];
                const sale=response.data.sale;
                if(sale!==undefined)
                {
                    sale.forEach(function(row,key){
                        if(key!==0)
                        {
                            app.chartOptions['series'][0]['data'].push([app.getMonthName(key),row]);
                        }
                    });
                }

                const commission=response.data.commission;
                if(commission!==undefined)
                {
                    commission.forEach(function(row,key){
                        if(key!==0)
                        {
                            app.chartOptions2['series'][0]['data'].push([app.getMonthName(key),row]);
                        }
                    });
                }

                this.years=response.data.year_list;
                this.year=response.data.default_year;
            }).catch(()=>{
                this.$root.$emit('hide_progress','');
            });
        },
        getMonthName:function(key){
            key=key-1;
            if(this.month[key]!==undefined)
            {
                return this.month[key];
            }
            else{
                return'';
            }
        },
        setYear:function (value){
            this.year=value;
            this.getData();
        }
    }

}
</script>

