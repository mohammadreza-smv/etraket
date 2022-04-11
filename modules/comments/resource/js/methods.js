export default {
    methods:{
        getDate:function (time,showMonth) {
            time=time*1000;
            const date=new Date(time);
            const jalali=this.gregorian_to_jalali(date.getFullYear(),(date.getMonth()+1),date.getDate());
            if(showMonth!==undefined){
                const r=this.replaceNumber(jalali[2])+" "+this.monthName[(jalali[1]-1)]+" "+this.replaceNumber(jalali[0]);
            }
            const r=this.replaceNumber(jalali[2])+" "+this.monthName[(jalali[1]-1)]+" "+this.replaceNumber(jalali[0]);
            return r;
        },
        getLabel2:function (key) {
            let score=this.avg_score[key];
            if(score>=0 && score<0.5)
            {
                return 'خیلی بد';
            }
            else if(score>=0.5 && score<=1)
            {
                return 'بد';
            }
            else if(score>1 && score<=2.5)
            {
                return 'معمولی';
            }
            else if(score>2.5 && score<3.2)
            {
                return 'خوب';
            }
            else if(score>=3.2)
            {
                return 'عالی';
            }
        },
        getWidth2:function (key) {
            let score=this.avg_score[key];
            score=score*25;
            return score;
        },
        add_comment:function () {
            if(this.auth=='no')
            {
                window.location=this.$siteUrl+"/login";
            }
            else {
                window.location=this.$siteUrl+"/product/comment/create/"+this.product_id;
            }
        },
        getLabel:function(key,key2) {
            key2=key2+1;
            const a="score"+key2;
            if(this.list.data[key]['get_score'][a]!=undefined)
            {
                return this.scoreLabel[this.list.data[key]['get_score'][a]];
            }
            else {
                return 'معمولی';
            }
        },
        getWidth:function (key,key2) {
            key2=key2+1;
            const a="score"+key2;
            if(this.list.data[key]['get_score'][a]!=undefined)
            {
                return (this.list.data[key]['get_score'][a]*25);
            }
            else {
                return 50;
            }
        },
        commentScore: function (element,type,redirect) {
            if (this.send) {
                $("#loading_box").show();
                this.send = false;
                const url = this.$siteUrl + "/user/comment/score/"+type;

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
        set_ordering:function (type) {
            this.ordering=type;
            this.getList(1);
        },
        addComment:function () {
            if(this.formDisabled===false){
                this.$refs.form.validate();
                if(this.valid) {
                    this.$vuetify.goTo(0);
                    this.serverError=false;
                    const formData=new FormData();
                    formData.append('title',this.title);
                    formData.append('content',this.content);
                    formData.append('score_item',JSON.stringify(this.score));
                    formData.append('advantage',JSON.stringify(this.advantageList));
                    formData.append('disadvantage',JSON.stringify(this.disadvantageList));
                    this.loading=true;
                    const url=this.$siteUrl+'/product/comment/create/'+this.product.id;
                    this.axios.post(url,formData).then(response=>{
                        this.loading=false;
                        if(response.data.status==='ok'){
                            this.serverRes=response.data.message;
                            this.formDisabled=true;
                        }
                        else{
                            this.serverError=true;
                        }

                    }).catch(error=>{
                        this.loading=false;
                        this.serverError=true;
                    })
                }
            }
        },
        addAdvantage:function () {
            if(this.advantage.trim()!==''){
                this.advantageList.push(this.advantage);
            }
        },
        addDisadvantage:function () {
            if(this.disadvantage.trim()!==''){
                this.disadvantageList.push(this.disadvantage);
            }
        },
        removeAdvantage:function (key) {
            this.$delete(this.advantageList, key);
        },
        removeDisadvantage:function (key) {
            this.$delete(this.disadvantageList, key)
        },
        sliderEvent:function () {
            const item_slider=document.querySelectorAll('.item_slider');
            const array=['slider_step_two','slider_step_three','slider_step_four','slider_step_five','slider_step_six'];
            for (let i = 0; i <item_slider.length ; i++) {
                item_slider[i].addEventListener('input',function () {
                    const newValue=item_slider[i].value;
                    const left=(100 - (newValue)*25)+'%';
                    item_slider[i].parentElement.querySelector('.rang_slider_div .active_rang_slider')
                        .style.left=left;
                    const steps=item_slider[i].parentElement.querySelectorAll('.rang_slider_div .js-slider-step')
                    for (let x = 0; x <steps.length; x++) {
                        steps[x].classList.remove('active_rang_step');
                    }
                    for (let j=0;j<newValue;j++)
                    {
                        item_slider[i].parentElement.querySelector('.rang_slider_div .'+array[j])
                            .classList.add('active_rang_step');
                    }

                    const title=item_slider[i].parentElement.querySelector('.rang_slider_div .'+array[newValue]).getAttribute('data-rate-title');
                    item_slider[i].parentElement.querySelector('.rang_slider_div').setAttribute('data-rate-title',title);
                });
            }
        }
    }
}
