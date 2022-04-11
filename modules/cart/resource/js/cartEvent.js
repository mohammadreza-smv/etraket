export default {
    methods: {
        change_price_fun:function (priceVariation) {
            if(priceVariation.product_count==0){
                let  msg='وضعیت محصول ';
                msg=msg+priceVariation.product.title+' ';
                msg=msg+'به ناموجود تغییر کرده است';
                this.changes_price.push(msg);
            }
            else if(priceVariation.initial_product_count!=undefined && priceVariation.initial_product_count!=priceVariation.product_count){
                let msg='تعداد محصول ';
                msg=msg+priceVariation.product.title+' ';
                msg=msg+'از '+replaceNumber(number_format(priceVariation.initial_product_count));
                msg=msg+' به '+replaceNumber(number_format(priceVariation.product_count))+' تغییر یافت';
                this.changes_price.push(msg);
            }

            if(priceVariation.product_count>0 && priceVariation.initial_amount!=undefined && (priceVariation.initial_amount!=priceVariation.price2)){
                let msg='قیمت محصول ';
                msg=msg+priceVariation.product.title+' ';
                msg=msg+'از '+replaceNumber(number_format(priceVariation.initial_amount))+' تومان ';
                msg=msg+'به '+replaceNumber(number_format((priceVariation.price2)))+' تومان تغییر پیدا کرد ';
                this.changes_price.push(msg);
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
        number_format: function (num) {
            num = num.toString();
            let format = '';
            let counter = 0;
            for (let i = num.length - 1; i >= 0; i--) {
                format += num[i];
                counter++;
                if (counter == 3 && i!==0) {
                    format += ",";
                    counter = 0;
                }
            }
            return format.split('').reverse().join('');
        },
        getPrice: function (price) {
            if (price == 0) {
                return "رایگان";
            } else {
                return this.replaceNumber(this.number_format(price)) + " تومان";
            }
        },
        goToPaymentPage:function () {
            const url=this.$siteUrl+'/payment?request-type=axios';
            const data=new FormData();
            const keys=Object.keys(this.sendPaymentPageData);
            for (let i = 0; i <keys.length ; i++) {
                data.append(keys[i],this.sendPaymentPageData[keys[i]]);
            }
            data.append('send_type',this.$store.state.OrdersStore.send_type);
            this.$root.$emit('send_post_request',url,data);
        }
    }
}
