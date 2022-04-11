export default {
    methods:{
        number_format:function (num){
            num=num.toString();
            let format='';
            let counter=0;
            for (let i=num.length-1;i>=0;i--)
            {
                format+=num[i];
                counter++;
                if(counter==3){
                    format+=",";
                    counter=0;
                }
            }
            return format.split('').reverse().join('');
        },
        replaceNumber:function (n){
            if(n!==undefined){
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
        getScoreValue:function (product) {
            let width=0;
            if(product.score_count>0)
            {
                width=product.score/(product.score_count*6);
            }
            width=width*20;
            return width;
        },
        show_product:function (product) {
            let url=this.shop_product_url;
            url=url.replace(':id',product.id);
            url=url.replace(':product_url',product.product_url);
            this.$root.$emit('send_get_request',url);
        },
        getImageUrl(){
            return this.$siteUrl+'/modules/favourite/stars.png';
        }
    }
}
