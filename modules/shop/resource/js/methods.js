export default {
    methods:{
        getFilterList:function () {
            const url=this.$siteUrl+'/api/shop/category/'+this.cat_id+'/filters';
            this.axios.get(url).then(response=>{
                this.filterList=response.data.original;
                this.sendRequest=false;
                const self=this;
                this.$nextTick(function () {
                    setTimeout(function () {
                        self.check_search_params();
                    },100);
                })
            }).catch(error=>{
                this.sendRequest=false;
            });
        },
        changeStatus:function (id) {
            if(this.boxStatus[id]===undefined){
                this.boxStatus[id]=true;
            }
            else{
                this.boxStatus[id]=!this.boxStatus[id];
            }
            this.$forceUpdate();
        },
        addFilter:function (paramName,id,keyparam) {
            if(this.checkbox[keyparam+id]===true){
                this.add_url_query_string(paramName,id);
            }
            else{
                this.remove_url_query_string(paramName,id);
            }
        },
        add_url_param:function (key,value,sendRequest) {
            let params=new window.URLSearchParams(window.location.search);
            let url=window.location.href;
            if(params.get(key)!=null){
                let old_param=key+"="+encodeURIComponent(params.get(key));
                let new_param=key+"="+value;
                url=url.replace(old_param,new_param);
            }
            else {
                const url_params=url.split('?');
                if(url_params[1]==undefined){
                    url=url+"?"+key+"="+value;
                }
                else {
                    url=url+"&"+key+"="+value;
                }
            }

            this.setPageUrl(url,sendRequest);
        },
        add_url_query_string:function (key,value) {
            let url=window.location.href;
            let check=url.split(key);
            const n=check.length-1;
            const url_params=url.split('?');
            if(url_params[1]===undefined){
                url=url+"?"+key+"["+n+"]="+value;
            }
            else {
                url=url+"&"+key+"["+n+"]="+value;
            }
            this.setPageUrl(url);
        },
        remove_url_params:function (key,value,page_url) {
            let params=new window.URLSearchParams(window.location.search);
            if(page_url!=undefined)
            {
                let search_url_params=this.search_url.split('?');
                if(search_url_params[1]!=undefined)
                {
                    search_url_params='?'+search_url_params[1];
                    params=new window.URLSearchParams(search_url_params);
                }
            }
            let url=page_url==undefined ? window.location.href : page_url;
            if(params.get(key)!=null){
                value=encodeURIComponent(value);
                url=url.replace('&'+key+"="+value,'');
                url=url.replace('?'+key+"="+value,'');
                // this.remove_filter_tag(key,value);

                const url_params=url.split('?');
                if(url_params[1]==undefined){
                    url=url.replace('&','?');
                }

                if(page_url==undefined)
                {
                    this.setPageUrl(url);
                }
                else {
                    this.search_url=url;
                }
            }
        },
        remove_url_query_string:function (key,value,page_url) {
            let url=page_url==undefined ? window.location.href : page_url;
            let check=url.split(key);
            const params=url.split('?');
            let h=0;
            if(params[1]!=undefined){
                if(params[1].indexOf('&')>-1){
                    let vars=params[1].split('&');
                    for (let i in vars){
                        let k=vars[i].split('=')[0];
                        let v=vars[i].split('=')[1];
                        let n=k.indexOf(key);
                        if(n>-1 && v!==value){
                            k=k.replace(key,'');
                            k=k.replace('[','');
                            k=k.replace(']','');
                            const new_string=key+"["+h+"]="+v;
                            const old_string=key+"["+k+"]="+v;
                            url=url.replace(old_string,new_string);
                            h++;
                        }
                        else if(n>-1){
                            url=url.replace('&'+k+"="+v,'');
                            url=url.replace('?'+k+"="+v,'');
                        }
                    }
                }
                else {
                    url=url.replace('?'+key+"[0]"+"="+value,'');
                }
            }

            const url_params=url.split('?');
            if(url_params[1]===undefined){
                url=url.replace('&','?');
            }
            this.setPageUrl(url);
        },
        setPageUrl:function (url,sendRequuest) {
            if(this.search_url!==undefined){
                this.search_url=url;
                if(sendRequuest){
                    window.history.pushState('data','title',url);
                    this.getProduct(this.search_url);
                }
            }
            else{
                window.history.pushState('data','title',url);
                if(sendRequuest===undefined){
                    this.getProduct(url);
                }
            }
        },
        getProduct:function (url) {
            const self=this;
            this.sendProductRequest=true;
            if(this.mobileApp===undefined){
                this.$vuetify.goTo(0);
            }
            this.clientRequest=true;
            const request_url=window.location.href.replace(this.$siteUrl,this.$siteUrl+'/getProduct');

            this.check_search_params();

            this.axios.get(request_url).then(response=>{
                if(response.data['product']!==undefined){
                    if(this.mobileApp!==undefined){

                        response.data['product'].data.forEach(function (item) {
                            self.products.data.push(item);
                        });
                        if(response.data['product'].data.length===0)
                        {
                            self.getServerData='no';
                        }
                    }
                    else{
                        this.products=response.data['product'];
                    }
                    if(response.data.max_price>0){
                        this.max=response.data.max_price;
                    }
                }
                this.sendProductRequest=false;
            });
        },
        paginate:function (page) {
            this.add_url_param('page',page);
        },
        set_sort:function (num) {
            this.sort=num;
            this.add_url_param('sortby',num);
        },
        setHasProduct:function () {
            if (this.has_product){
                this.add_url_param('has_product',1);
            }
            else{
                this.remove_url_params('has_product',1);
            }
        },
        setHasReadyToShipment:function () {
            if (this.has_ready_to_shipment){
                this.add_url_param('has_ready_to_shipment',1);
            }
            else{
                this.remove_url_params('has_ready_to_shipment',1);
            }
        },
        searchProduct:function () {
            if(this.searchTextString.length>1){
                this.add_url_param('string',this.searchTextString);
            }
            else if(this.searchTextString.toString().trim()===''){
                let params=new window.URLSearchParams(window.location.search);
                this.remove_url_params('string',params.get('string'));
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
        setRangePrice:function (val) {
            this.priceRange=[val[0],val[1]];
        },
        priceFilter:function () {
            this.add_url_param('price[min]',this.priceRange[0],false);
            this.add_url_param('price[max]',this.priceRange[1]);
        },
        check_search_params:function (page_url) {
            let url=page_url==undefined ? window.location.href : page_url;
            const params=url.split('?');
            this.selected_filter=[];
            this.checkbox={};
            if(params[1]!==undefined){
                if(params[1].indexOf('&')>-1){
                    let vars=params[1].split('&');
                    for (let i in vars){
                        let k=vars[i].split('=')[0];
                        let v=vars[i].split('=')[1];
                        k=k.split('[');
                        this.add_active_filter(k,v);
                    }
                }
                else {
                    let k=params[1].split('=')[0];
                    let v=params[1].split('=')[1];
                    k=k.split('[');
                    this.add_active_filter(k,v);
                }
            }
        },
        add_active_filter:function (key,value) {
            if(key.length>1){
                if(key.length===3){
                    this.checkbox[key[0]+'['+key[1]+'_'+value]=true;
                    const id=key[1].toString().replace(']','');
                    this.addFilterTag(key[0],id,value);
                    this.boxStatus[key[0]+'['+key[1]]=true;
                }
                else{
                    this.checkbox[key[0]+'_'+value]=true;
                    this.addFilterTag(key[0],null,value);
                }
            }
            this.$forceUpdate();
        },
        addFilterTag:function (param,key,value) {
             let label1=null;
             let label2=null;
             if(param==='brand' && this.filterList['brands']!==undefined){
                 for (let i = 0; i <this.filterList['brands'].length ; i++) {
                       if(this.filterList['brands'][i].brand_id===parseInt(value)){
                             label1='برند';
                             if(this.filterList['brands'][i].get_brand!==null){
                                 label2=this.filterList['brands'][i].get_brand.brand_name;
                             }
                       }
                 }
                 if(label1!==null && label2!==null){
                     const event='addFilter("brand","'+value+'","brand_")';
                     this.selected_filter.push({
                             label1:label1,
                             label2:label2,
                             event_key1:'brand',
                             event_value:value,
                             event_key2:'brand_'
                     });
                 }
             }
             else if(param==='color' && this.filterList['colors']!==undefined){
                for (let i = 0; i <this.filterList['colors'].length ; i++) {
                    if(this.filterList['colors'][i].id===parseInt(value)){
                        label1='رنگ';
                        if(this.filterList['colors'][i].name!==null){
                            label2=this.filterList['colors'][i].name;
                        }
                    }
                }
                if(label1!==null && label2!==null){
                    const event='addFilter("color","'+value+'","color_")';
                    this.selected_filter.push({
                        label1:label1,
                        label2:label2,
                        event_key1:'color',
                        event_value:value,
                        event_key2:'color_'
                    });
                }
            }
             else{
                 for (let i = 0; i <this.filterList['customItems'].length ; i++) {
                     const row=this.filterList['customItems'][i];
                     if(row.param===param || row.param===param+'['+key+']'){
                         for (let j = 0; j < row.items.length; j++) {
                             if(row['items'][j].id==value){
                                 label2=row['items'][j].title;
                             }
                         }
                         if(label2!==null){
                             const event='addFilter("'+param+'","'+value+'","'+param+'_")';
                             this.selected_filter.push({
                                 label1:row.title,
                                 label2:label2,
                                 event_key1:param+'['+key+']',
                                 event_value:value,
                                 event_key2:param+'_'
                             });
                         }

                     }
                 }
             }
        },
        filterProduct:function () {
            this.drawer=false;

            let params=new window.URLSearchParams(window.location.search);
            if(params.get('page')!=null){
                this.search_url=this.search_url.replace('page='+params.get('page'),'page=1');
            }

            this.setPageUrl(this.search_url,true);
            this.hasFilter=true;
            this.search_url='';
        },
        sortProduct:function () {
            this.sortDrawer=false;
            this.add_url_param('sortby',  this.sort);
            this.setPageUrl(this.search_url,true);
            this.search_url='';
        },
        getDiscountValue: function getDiscountValue(price1, price2) {
            var a = price2 / price1 * 100;
            a = 100 - a;
            a = Math.round(a);
            return a;
        },
        goToProductPage:function (product) {
            let url=this.product_url;
            url=url.toString().replace(':id',product.id);
            url=url.toString().replace(':product_url',product.product_url);
            this.$root.$emit('send_get_request',url);
        },
        run_filter_event:function (item,itemKey){
            if(this.checkbox[item['event_key1']+'_'+item['event_value']]===true){
                this.remove_url_query_string(item['event_key1'],item['event_value']);
            }
        }
    }
}
