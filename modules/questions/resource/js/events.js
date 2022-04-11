export default {
    methods:{
        add_question:function(){
            if(this.Question.trim()!=="")
            {
                if(this.send)
                {
                    this.serverError=false;
                    this.send=false;
                    const url=this.$siteUrl+"/user/addQuestion";
                    const formData=new FormData();
                    formData.append('product_id',this.product_id);
                    formData.append('question',this.Question);
                    formData.append('send_email',this.send_email);
                    formData.append('question_id',0);
                    this.axios.post(url,formData).then(response=>{
                        this.send=true;
                        if(response.data==='ok'){
                            this.save_question=true;
                            this.Question='';
                        }
                    }).catch(error=>{
                        this.send=true;
                        this.serverError=true;
                    });
                }
            }
        },
        add_answer:function(question_id){
            if(this.answer.trim()!=="")
            {
                if(this.send_answer)
                {
                    this.serverError=false;
                    this.send_answer=false;
                    const url=this.$siteUrl+"/user/addQuestion";
                    const formData=new FormData();
                    formData.append('product_id',this.product_id);
                    formData.append('question',this.answer);
                    formData.append('question_id',question_id);
                    this.axios.post(url,formData).then(response=>{
                        this.send_answer=true;
                        if(response.data==='ok'){
                            this.save_answer=true;
                            this.answer='';
                        }
                    }).catch(error=>{
                        this.send_answer=true;
                        this.serverError=true;
                    });
                }
            }
        },
        getDate:function (time) {
            time=time*1000;
            const date=new Date(time);
            const jalali=this.gregorian_to_jalali(date.getFullYear(),(date.getMonth()+1),date.getDate());
            const r=this.replaceNumber(jalali[2])+" "+this.monthName[(jalali[1]-1)]+" "+this.replaceNumber(jalali[0]);
            return r;
        },
        questionScore: function (element,type,redirect) {
            if (this.send) {
                $("#loading_box").show();
                this.send = false;
                const url = this.$siteUrl + "/user/question/score/"+type;

                const formData = new FormData();
                formData.append('row_id', element.id);

                this.axios.post(url, formData).then(response => {
                    this.send = true;
                    $("#loading_box").hide();
                    if(response.data!='error'){
                        element.like=response.data.like;
                        element.dislike=response.data.dislike;
                    }
                })
                    .catch(error => {
                        this.send = true;
                        $("#loading_box").hide();
                        if (error.response.status == 401) {
                            if (redirect != undefined) {
                                this.$refs.loginBox.show_box();
                            } else {
                                $("#login_box").modal('show');
                            }
                        }
                    });

            }
        },
        gregorian_to_jalali: function (gy, gm, gd) {
            var g_d_m, jy, jm, jd, gy2, days;
            g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
            if (gy > 1600) {
                jy = 979;
                gy -= 1600;
            } else {
                jy = 0;
                gy -= 621;
            }
            gy2 = (gm > 2) ? (gy + 1) : gy;
            days = (365 * gy) + (parseInt((gy2 + 3) / 4)) - (parseInt((gy2 + 99) / 100)) + (parseInt((gy2 + 399) / 400)) - 80 + gd + g_d_m[gm - 1];
            jy += 33 * (parseInt(days / 12053));
            days %= 12053;
            jy += 4 * (parseInt(days / 1461));
            days %= 1461;
            if (days > 365) {
                jy += parseInt((days - 1) / 365);
                days = (days - 1) % 365;
            }
            jm = (days < 186) ? 1 + parseInt(days / 31) : 7 + parseInt((days - 186) / 30);
            jd = 1 + ((days < 186) ? (days % 31) : ((days - 186) % 30));
            return [jy, jm, jd];
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
        changeStatus:function(question,key){
            if(this.removed){
                const url = this.$siteUrl + "/admin/question/change_status";
                this.$root.$emit('show_progress');
                const formData=new FormData();
                formData.append('question_id',question.id);
                this.axios.post(url,formData).then(response=>{
                    if(response.data=='ok'){
                        if(this.questionList.data[key].status===0){
                            this.questionList.data[key].status=1;
                        }
                        else{
                            this.questionList.data[key].status=0;
                        }
                        this.$forceUpdate();
                    }
                    this.$root.$emit('hide_progress');
                }).catch(error=>{
                    this.$root.$emit('hide_progress');
                });
            }
        },
    }
}
