<template>
    <div  :class="className">
        <v-menu
            v-model="menu"
            :close-on-content-click="false"
            max-width="290"
        >
            <template v-slot:activator="{ on, attrs }">

                <v-text-field
                    v-model="dateFormatted"
                    clearable
                    :label="label!=='false' ? label : ''"
                    outlined
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    @click:clear="date = null"
                    @blur="date = parseDate(dateFormatted)"
                    dense
                ></v-text-field>

            </template>
            <v-date-picker
                v-model="date"
                @change="menu = false"
                locale="fa"
            ></v-date-picker>
        </v-menu>

        <input type="hidden" :name="name" v-model="dateFormatted">
    </div>
</template>

<script>
    export default {
        name: "DateInput",
        props:['label','name','args','value',],
        data: () => ({
            date: null,
            dateFormatted:null,
            menu: false,
            className:'c-field',
            options:[],
        }),
        mounted() {
            this.dateFormatted=this.value;
            if(this.value==='null'){
                this.input='';
            }
            if(this.args!=null){
                this.options=this.args;
                if(this.options['validate']!==undefined){
                    this.setValidate(this.options['validate']);
                }
                if(this.options['class']!==undefined){
                    this.className= this.className+' '+this.options['class'];
                }
            }
        },
        methods:{
            formatDate (date) {
                if (!date) return null
                const [year, month, day] = date.split('-');
                const jalali=this.gregorian_to_jalali(parseInt(year),parseInt(month),parseInt(day));
                return `${jalali[0]}/${jalali[1]}/${jalali[2]}`;
            },
            parseDate (date) {
                if (!date) return null;
                const [month, day, year] = date.split('/');
                if(parseInt(year)>2000){
                    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
                }
            },
            gregorian_to_jalali (gy, gm, gd) {
                var g_d_m, jy, jm, jd, gy2, days;
                g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
                gy2 = (gm > 2) ? (gy + 1) : gy;
                days = 355666 + (365 * gy) + ~~((gy2 + 3) / 4) - ~~((gy2 + 99) / 100) + ~~((gy2 + 399) / 400) + gd + g_d_m[gm - 1];
                jy = -1595 + (33 * ~~(days / 12053));
                days %= 12053;
                jy += 4 * ~~(days / 1461);
                days %= 1461;
                if (days > 365) {
                    jy += ~~((days - 1) / 365);
                    days = (days - 1) % 365;
                }
                if (days < 186) {
                    jm = 1 + ~~(days / 31);
                    jd = 1 + (days % 31);
                } else {
                    jm = 7 + ~~((days - 186) / 30);
                    jd = 1 + ((days - 186) % 30);
                }
                return [jy, jm, jd];
            }
        },
        watch: {
            date (val) {
                this.dateFormatted = this.formatDate(this.date);
            },
        },
    }
</script>

