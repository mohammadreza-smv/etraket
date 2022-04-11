export default {
    methods:{
        checkMobileNumber:function(value){
            if(isNaN(value))
            {
                return  'شماره موبایل وارد شده معتبر نمی باشد';
            }
            else {
                if(value.toString().trim().length==11)
                {
                    if(value.toString().charAt(0)=='0' && value.toString().charAt(1)=='9' )
                    {
                        return true;
                    }
                    else
                    {
                        return  'شماره موبایل وارد شده معتبر نمی باشد';
                    }
                }
                else if(value.toString().trim().length==10)
                {
                    if(value.toString().charAt(0)=='9')
                    {
                        return true;
                    }
                    else
                    {
                        return  'شماره موبایل وارد شده معتبر نمی باشد';
                    }
                }
                else{
                    return  'شماره موبایل وارد شده معتبر نمی باشد';
                }
            }
        },
        login:function (url) {
            this.$refs.form.validate();
            if(this.valid &&  this.loading===false){
                this.loading=true;
                this.disabled=true;

                const formData = new FormData();
                if(this.type=='admin-from'){
                    formData.append('username', this.username);
                }
                else{
                    formData.append('mobile', this.mobile);
                }
                formData.append('password', this.password);
                formData.append('remember', this.remember);

                const url = this.$siteUrl + "/login";
                this.serverError = false;
                this.axios.post(url, formData).then(response => {
                    this.loading=false;
                    this.disabled=false;
                    if (response.data.status == 'ok') {
                        if(url===undefined){
                            window.location =  this.$siteUrl;
                        }
                        else{
                            window.location =  window.location.href;
                        }
                    } else {
                        this.serverError = response.data.status;
                    }
                }).catch(error => {
                    this.loading=false;
                    this.disabled=false;
                    this.serverError = 'خطا در ارسال اطلاعات مجددا تلاش نمایید';
                });
            }
            else{
                this.$refs.form.validate();
            }
        },
        register:function () {
            this.$refs.form.validate();
            if(this.valid &&  this.loading===false){
                this.loading=true;
                this.disabled=true;
                this.validateError=[];
                const formData = new FormData();
                formData.append('mobile', this.mobile);
                formData.append('password', this.password);

                const url = this.$siteUrl + "/register";
                this.serverError = false;
                this.axios.post(url, formData).then(response => {
                    this.loading=false;
                    this.disabled=false;
                    if (response.data.status === 'ok') {
                         this.step=2;
                         this.show_second=180;
                         this.timeOut=setInterval(this.counter,1000);
                    } else {
                        this.serverError = response.data.status;
                    }
                }).catch(error => {
                    this.loading=false;
                    this.disabled=false;
                    if(error.response.data!==undefined && error.response.data['errors']!==undefined){
                        const errors=error.response.data['errors'];
                        const keys=Object.keys(errors);
                        for (let i = 0; i <keys.length ; i++) {
                            if(errors[keys[i]][0]!==undefined){
                                this.validateError.push(errors[keys[i]][0]);
                            }
                        }
                    }
                    else{
                        this.serverError = 'خطا در ارسال اطلاعات مجددا تلاش نمایید';
                    }
                });
            }
        },
        changeActiveCode:function (val) {
           if (this.activeCode.toString().length===6){
               this.sendActiveCode();
           }
        },
        changeActiveCode2:function(val){
            if (this.activeCode.toString().length===6){
                this.loading=true;
                this.serverError='';
                const formData = new FormData();
                formData.append('mobile', this.mobile);
                formData.append('active_code', this.activeCode);

                const url = this.$siteUrl + "/user/change-mobile-number";
                this.axios.post(url, formData).then(response => {
                    this.loading=false;
                    if (response.data === 'ok') {
                        this.$root.$emit('send_get_request',window.location.href);
                    } else {
                        this.serverError = response.data.error;
                    }
                }).catch(error => {
                    this.serverError=false;
                    this.serverError = 'خطا در ارسال اطلاعات مجددا تلاش نمایید';
                });
            }
        },
        counter:function () {
            let second=this.show_second;
            if(second>-1){
                 let h=Math.floor(second/3600);
                 second=second-h*3600;
                 let m=Math.floor(second/60);
                 let s=second-m*60;
                 if(h.toString().length==1)
                 {
                     h="0"+h;
                 }
                 if(m.toString().length==1)
                 {
                     m="0"+m;
                 }
                 if(s.toString().length==1)
                 {
                     s="0"+s;
                 }
                 this.h=this.replaceNumber(h);
                 this.m=this.replaceNumber(m);
                 this.s=this.replaceNumber(s);
                 this.show_second=this.show_second-1;
            }
            else{
                clearTimeout(this.timeOut);
            }
        },
        replaceNumber:function (n) {
            n=n.toString();
            const find=["0","1","2","3","4","5","6","7","8","9"];
            const replace=["۰","۱","۲","۳","۴","۵","۶","۷","۸","۹"];
            for (let i=0;i<find.length;i++)
            {
                n=n.replace(new RegExp(find[i],'g'),replace[i]);
            }
            return n;
        },
        sendActiveCode:function () {
            this.loading=true;
            this.disabled=true;
            this.serverError='';
            this.validateError=[];

            const formData = new FormData();
            formData.append('mobile', this.mobile);
            formData.append('active_code', this.activeCode);

            const url = this.$siteUrl + "/register/active_account";
            this.serverError = false;
            this.axios.post(url, formData).then(response => {
                this.loading=false;
                this.disabled=false;
                if (response.data.status === 'ok') {
                    window.location.href=this.$siteUrl;
                } else {
                    this.serverError = response.data.status;
                }
            }).catch(error => {
                this.loading=false;
                this.disabled=false;
                this.serverError = 'خطا در ارسال اطلاعات مجددا تلاش نمایید';
            });

        },
        resend_active_code:function (forget) {
            if(this.show_second<=0){
                this.loading=true;
                this.disabled=true;
                this.validateError=[];
                const formData = new FormData();
                formData.append('mobile', this.mobile);
                if(forget!==undefined){
                    formData.append('forget_password','ok');
                }

                const url = this.$siteUrl + "/register/ajax/resend";
                this.serverError = false;
                this.axios.post(url, formData).then(response => {
                    this.loading=false;
                    this.disabled=false;
                    if (response.data === 'ok') {
                        this.show_second=180;
                        clearInterval(this.timeOut);
                        this.timeOut=setInterval(this.counter,1000);
                        this.snackbar=true;
                    } else {
                        this.serverError ='خطا در اجرای درخواست,مجددا تلاش نمایید';
                    }
                }).catch(error => {
                    this.loading=false;
                    this.disabled=false;
                    this.serverError = 'خطا در ارسال اطلاعات مجددا تلاش نمایید';
                });
            }
        },
        setMobileNumber:function () {
            this.$refs.form.validate();
            if(this.valid &&  this.loading===false) {

                this.loading=true;
                this.disabled=true;
                this.error='';
                const formData = new FormData();
                formData.append('mobile', this.mobile);

                const url = this.$siteUrl + "/password/email";
                this.axios.post(url, formData).then(response => {
                    this.loading=false;
                    this.disabled=false;

                    if(response.data['status']==='ok'){
                        this.step=2;
                        this.show_second=180;
                        if(this.timeOut!==null){
                            clearInterval(this.timeOut);
                        }
                        this.timeOut=setInterval(this.counter,1000);
                    }
                    else{
                        this.error=response.data['message'];
                    }

                }).catch(error=>{
                    this.loading=false;
                    this.disabled=false;
                    this.error='خطا در ارتباط با سرور،مجددا تلاش نمایید';
                });
            }
        },
        sendForgetCode:function () {

            this.loading=true;
            this.disabled=true;
            this.error='';

            const formData = new FormData();
            formData.append('mobile', this.mobile);
            formData.append('forget_password_code', this.code);

            const url = this.$siteUrl + "/password/confirm";
            this.error = '';
            this.axios.post(url, formData).then(response => {
                this.loading=false;
                this.disabled=false;
                if (response.data.status === 'ok') {
                   this.step=3;
                   this.token=response.data['token'];
                } else {
                    this.error = response.data['message'];
                }
            }).catch(error => {
                this.loading=false;
                this.disabled=false;
                this.error = 'خطا در ارسال اطلاعات مجددا تلاش نمایید';
            });

        },
        changePassword:function () {
            this.$refs.form2.validate();
            if(this.valid &&  this.loading===false) {
                this.loading=true;
                this.disabled=true;
                this.error='';

                const formData = new FormData();
                formData.append('mobile', this.mobile);
                formData.append('password', this.password1);
                formData.append('password_confirmation', this.password2);
                formData.append('token', this.token);

                const url = this.$siteUrl + "/password/reset";
                this.error = '';
                this.axios.post(url, formData).then(response => {
                    this.loading=false;
                    this.disabled=false;
                    if (response.data.status === 'ok') {
                        window.location.href=this.$siteUrl;
                    }
                    else {
                        this.error = response.data['message'];
                    }
                }).catch(error => {
                    this.loading=false;
                    this.disabled=false;
                    this.error = 'خطا در ارسال اطلاعات مجددا تلاش نمایید';
                });
            }
        },
        confirmationPassword:function () {
            if(this.password1===this.password2){
                return true;
            }
            else{
                return  'تکرار کلمه عبور مطابقت ندارد';
            }
        },
        parseDate:function (date) {
            if(!date) return null;
            const [year,month,day]=date.split('/');
            const gregorian=this.jalali_to_gregorian(
                parseInt(year),
                parseInt(month),
                parseInt(day)
            );
            let m=gregorian[1];
            if(m.length===1){
                m='0'+m;
            }

            let d=gregorian[2];
            if(d.length===1){
                d='0'+m;
            }

            return  `${gregorian[0]}-0${m}-${d}`;
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
        },
        jalali_to_gregorian(jy, jm, jd) {
            var sal_a, gy, gm, gd, days;
            jy += 1595;
            days = -355668 + (365 * jy) + (~~(jy / 33) * 8) + ~~(((jy % 33) + 3) / 4) + jd + ((jm < 7) ? (jm - 1) * 31 : ((jm - 7) * 30) + 186);
            gy = 400 * ~~(days / 146097);
            days %= 146097;
            if (days > 36524) {
                gy += 100 * ~~(--days / 36524);
                days %= 36524;
                if (days >= 365) days++;
            }
            gy += 4 * ~~(days / 1461);
            days %= 1461;
            if (days > 365) {
                gy += ~~((days - 1) / 365);
                days = (days - 1) % 365;
            }
            gd = days + 1;
            sal_a = [0, 31, ((gy % 4 === 0 && gy % 100 !== 0) || (gy % 400 === 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            for (gm = 0; gm < 13 && gd > sal_a[gm]; gm++) gd -= sal_a[gm];
            return [gy, gm, gd];
        },
        formatData:function (date) {
            if(!date) return null;
            const [year,month,day]=date.split('-');
            const jalali=this.gregorian_to_jalali(
                parseInt(year),
                parseInt(month),
                parseInt(day)
            );
            return  `${jalali[0]}/${jalali[1]}/${jalali[2]}`;
        },
    }
}
