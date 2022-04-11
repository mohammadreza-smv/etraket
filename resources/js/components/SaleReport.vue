<template>
     <div>
           <p>
               <span>میزان فروش در سال </span>
               <select v-model="default_year" class="selectpicker auto_width years_tag" v-on:change="getData()" ref="default_year">
                   <option v-bind:value="year"  v-for="(year,key) in years" v-bind:key="key">{{ replaceNumber(year) }}</option>
               </select>
           </p>
           <highcharts :options="chartOptions"></highcharts>
           <div style="padding-top:50px">
               <highcharts :options="chartOptions2"></highcharts>
           </div>
     </div>
</template>

<script>
import {Chart} from 'highcharts-vue'
export default {
    props:['product_id'],
    data(){
        return {
            default_year:'',
            years:[],
            chartOptions: {
                   series: [{
                       data:[],
                       color:'rgb(244,81,108)',
                       dataLabels:{
                           enabled:true,
                           color:'#FFFFFF',
                           formatter:function(){
                               return replaceNumber(number_format(this.y));
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
                                value=number_format(value);
                                }
                               value=replaceNumber(value);
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
                              '<p><span> میزان فروش در</span> '+ getMonthName((this.x))+' ماه</p>'+
                              '<div style="text-align:left;color:rgb(244,81,108);direction:rtl">'+
                                  '<span>'+ replaceNumber(number_format(this.y)) +'</span>'+
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
                               return replaceNumber(number_format(this.y));
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
                       text:'کمیسیون دریافت شده از فروش محصول',
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
                                value=number_format(value);
                                }
                               value=replaceNumber(value);
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
                              '<p><span> میزان دریافت کمیسیون در</span> '+ getMonthName((this.x+1))+' ماه</p>'+
                              '<div style="text-align:left;color:rgb(244,81,108);direction:rtl">'+
                                  '<span>'+ replaceNumber(number_format(this.y)) +'</span>'+
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
            url:''
        }
    },
    components: {
            highcharts: Chart
    },
    mounted(){
        this.getData();
    },
    methods:{
        getData:function()
        {
            if(this.product_id==undefined){
                this.url=this.$siteUrl+'/admin/shop/get_sale_report?default_year='+this.default_year;
            }
            else{
                this.url=this.$siteUrl+'/admin/product/get_sale_report?default_year='+this.default_year+'&product_id='+this.product_id;
            }
            $("#loading_box").show();
            const app=this;
            this.axios.get(this.url).then(response=>{
               $("#loading_box").hide();
               this.chartOptions['series'][0]['data']=[];
                const sale=response.data.sale;
                if(sale!=undefined)
                {
                    sale.forEach(function(row,key){
                        if(key!=0)
                        {
                            app.chartOptions['series'][0]['data'].push([app.getMonthName(key),row]);
                        }
                    });
                }

                const commision=response.data.commision;
                if(commision!=undefined)
                {
                    commision.forEach(function(row,key){
                        if(key!=0)
                        {
                            app.chartOptions2['series'][0]['data'].push([app.getMonthName(key),row]);
                        }
                    });
                }

                this.years=response.data.year_list;
                this.default_year=response.data.default_year;

                this.$nextTick(function(){
                    $(this.$refs.default_year).selectpicker('refresh');
                });
            }).catch(error=>{
                $("#loading_box").hide();
            });
        },
        getMonthName:function(key){
            key=key-1;
            if(this.month[key]!=undefined)
            {
                return this.month[key];
            }
            else{
                 return'';
            }
        },
        replaceNumber:function (n){
           if(n!=undefined){
              n=n.toString();
              const find=["0","1","2","3","4","5","6","7","8","9"];
              const replace=["۰","۱","۲","۳","۴","۵","۶","۷","۸","۹"];
              for (let i=0;i<find.length;i++)
              {
                  n=n.replace(new RegExp(find[i],'g'),replace[i]);
              }
              return n;
           }
        },
    }
}
</script>

<style>

</style>
