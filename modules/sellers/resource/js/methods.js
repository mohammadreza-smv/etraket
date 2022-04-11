export default {
    methods:{
        replaceNumber: function (n) {
            if (n !==undefined) {
                n = n.toString();
                const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                for (let i = 0; i < find.length; i++) {
                    n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                }
                return n;
            }
        },
        sendActiveCode:function () {
            if (this.activeCode.toString().length===6){
                this.send = true;
                const form_data = new FormData();
                form_data.append("mobile", this.mobile);
                form_data.append("code", this.activeCode);
                this.axios
                    .post(this.$siteUrl + "/api/seller/check_active_code", form_data)
                    .then(response => {
                        this.send = false;
                        if (response.data.original.status ==="ok") {
                            this.$root.$emit('seller_register_next_step');
                        }
                        else
                        {
                           this.serverError=response.data.original['message'];
                        }
                    })
                    .catch(() => {
                        this.send = false;
                        this.serverError='خطا در ارتباط با سرور مجددا تلاش نمایید';
                    });
            }
        },
        sendProfileActiveCode:function(){
            if (this.activeCode.toString().length===6){
                const url=this.$siteUrl+'/sellers/panel/profile/check_active_code';
                const formData=new FormData();
                formData.append("mobile", this.mobile);
                formData.append("code", this.activeCode);
                formData.append("encrypted", this.encrypted);
                this.$root.$emit('send_post_request',url,formData);
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
        resend_active_code: function(forget) {
            if (this.show_second<1 && this.resend) {
                clearInterval(this.timer);
                this.resend = false;
                const form_data = new FormData();
                let url=this.$siteUrl + "/api/seller/resend_active_code";
                form_data.append("mobile", this.mobile);
                if(forget!==undefined){
                    form_data.append('forget_password','ok');
                }
                this.axios
                    .post(url, form_data)
                    .then(response => {
                        this.resend = true;
                        if (response.data.original.status === "error") {
                            this.serverError='خطا در ارتباط با سرور مجددا تلاش نمایید';
                        } else {
                            this.show_second = 180;
                            this.counter();
                            this.timer=setInterval(this.counter,1000);
                        }
                    })
                    .catch(() => {
                        this.resend = true;
                        this.serverError='خطا در ارتباط با سرور مجددا تلاش نمایید';
                    });
            }
        },
        number_format: function (num) {
            num = num.toString();
            let format = '';
            let counter = 0;
            for (let i = num.length - 1; i >= 0; i--) {
                format += num[i];
                counter++;
                if (counter == 3) {
                    format += ",";
                    counter = 0;
                }
            }
            return format.split('').reverse().join('');
        },
        checkMobileNumber:function(value){
            value=this.replaceFaNumber(value);
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
        replaceFaNumber:function (n) {
            n=n.toString();
            const replace=["0","1","2","3","4","5","6","7","8","9"];
            const find=["۰","۱","۲","۳","۴","۵","۶","۷","۸","۹"];
            for (let i=0;i<find.length;i++)
            {
                n=n.replace(new RegExp(find[i],'g'),replace[i]);
            }
            return n;
        },
        setMobileNumber:function () {
            this.$refs.form.validate();
            if(this.valid &&  this.loading===false) {

                this.loading=true;
                this.disabled=true;
                this.error='';
                const formData = new FormData();
                formData.append('mobile', this.replaceFaNumber(this.mobile));

                const url = this.$siteUrl + "/sellers/password/email";
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
            formData.append('mobile', this.replaceFaNumber(this.mobile));
            formData.append('forget_password_code', this.code);

            const url = this.$siteUrl + "/sellers/password/confirm";
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
        confirmationPassword:function () {
            if(this.password1===this.password2){
                return true;
            }
            else{
                return  'تکرار کلمه عبور مطابقت ندارد';
            }
        },
        changePassword:function () {
            this.$refs.form2.validate();
            if(this.valid &&  this.loading===false) {
                this.loading=true;
                this.disabled=true;
                this.error='';

                const formData = new FormData();
                formData.append('mobile',this.replaceFaNumber(this.mobile));
                formData.append('password', this.password1);
                formData.append('password_confirmation', this.password2);
                formData.append('token', this.token);

                const url = this.$siteUrl + "/sellers/password/reset";
                this.error = '';
                this.axios.post(url, formData).then(response => {
                    this.loading=false;
                    this.disabled=false;
                    if (response.data.status === 'ok') {
                        window.location.href=this.$siteUrl+'/sellers/login';
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
    }
}
