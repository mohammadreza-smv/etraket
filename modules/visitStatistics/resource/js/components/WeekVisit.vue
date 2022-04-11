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
            item-color="white"
        ></v-select>

         <div v-for="i in 8">
             <div v-if="i<8"  style="display: flex;align-items: center">
                 <span class="day-week">{{ getDayOfWeek(i) }}</span>
                 <div v-for="h in 24" class="h_div"
                      :style="{backgroundColor:getBackgroundColor(i,h) }"
                      @click="showDetail(i,h)"
                 ></div>
             </div>
             <div v-else  style="display: flex;align-items: center">
                 <span class="day-week"></span>
                 <div v-for="j in 24" class="hour_num">
                     <span>{{ replaceNumber((j-1)) }}</span>
                 </div>
             </div>
         </div>

         <v-dialog
             width="400"
             v-model="dialog"
         >
             <v-card>
                 <v-card-text>
                      <div style="text-align: center">
                          <div style="padding:20px 10px 10px;color: black">
                              تعداد بازدید : {{ replaceNumber(hour_view) }}
                          </div>
                          <div style="padding:10px;color: black">
                              درصد در طول روز : {{ replaceNumber(Math.round(hour_percentage)) }}
                          </div>
                      </div>
                 </v-card-text>
             </v-card>
         </v-dialog>
    </div>
</template>

<script>
import methods from '../methods.js';
export default {
    name: "WeekVisit",
    mixins:[methods],
    data(){
        return {
            dialog:false,
            hour_view:0,
            hour_percentage:0,
            visit:[],
            year:'',
            years:[],
            week:[
                'شنبه',
                'یک شنبه',
                'دو شنبه',
                'سه شنبه',
                'چهار شنبه',
                'پنج شنبه',
                'جمعه',
            ],
            dayVisit:{},
            colors: {
                '0-10':'#E0F7FA',
                '10-20':'#B2EBF2',
                '20-30':'#80DEEA',
                '30-40':'#4DD0E1',
                '40-50':'#26C6DA',
                '50-60':'#00ACC1',
                '60-70':'#0097A7',
                '70-80':'#00838F',
                '80-90':'#006064',
                '90-100':'black'
            }
        }
    },
    mounted() {
        this.getData();
    },
    methods:{
        getData:function (){
            let url=this.$siteUrl+'/admin/statistics/week/visit';
            if(this.year!==''){
                url=url+'/'+this.year;
            }
            this.axios.get(url).then(response=>{
                this.dayVisit={};
                if(response.data.years!==undefined){
                    this.years=response.data.years;
                    this.year=parseInt(response.data.year);
                    this.visit=response.data.visit;
                    for (let i = 0; i <this.visit.length; i++) {
                        if(this.dayVisit[this.visit[i]['days_of_week']]===undefined){
                            this.dayVisit[this.visit[i]['days_of_week']]=parseInt(this.visit[i]['view']);
                        }
                        else{
                            this.dayVisit[this.visit[i]['days_of_week']]=  this.dayVisit[this.visit[i]['days_of_week']]+parseInt(this.visit[i]['view']);
                        }
                    }
                    this.$forceUpdate();
                }
            }).catch(error=>{

            });
        },
        getDayOfWeek:function(k){
            k=k-1;
            return this.week[k];
        },
        getBackgroundColor:function (i,h){
            const day=(i-1);
            const hour=(h-1);
            let view=0;
            let d=0;
            let color='';

            for (let j = 0; j <this.visit.length ; j++) {
                if(this.visit[j].hour==hour && this.visit[j].days_of_week==day){
                    view=this.visit[j].view;
                    if(view>0){
                        d=(view/this.dayVisit[this.visit[j].days_of_week])*100;
                    }
                }
            }

            const colorKeys=Object.keys(this.colors);
            for (let j = 0; j <colorKeys.length ; j++) {
                const k=colorKeys[j].split('-');
                if(d>parseInt(k[0]) && d<=parseInt(k[1])){
                    color=this.colors[colorKeys[j]];
                }
            }

            return color;
        },
        showDetail:function (i,h){
            this.hour_view=0;
            this.hour_percentage=0;
            const day=(i-1);
            const hour=(h-1);
            for (let j = 0; j <this.visit.length ; j++) {
                if(this.visit[j].hour==hour && this.visit[j].days_of_week==day){
                    this.hour_view=this.visit[j].view;
                    if(this.hour_view>0){
                        this.hour_percentage=( this.hour_view/this.dayVisit[this.visit[j].days_of_week])*100;
                    }
                }
            }

            this.dialog=true;
        },
        setYear:function (value){
            this.year=value;
            this.getData();
        }
    }
}
</script>

<style>
   @import "../style.css";
</style>
