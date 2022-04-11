export default {
    namespaced: true,
    state: () => ({
        cart_type:1,
        selected_price_variation:null,
        show_dialog_box:false,
        cartData:null,
        show_next_cart_message:false,
        shop_product_url:'',
        progress:false
    }),
    mutations: {
        change_show_tab:function (state,key) {
            state.cart_type=key;
        },
        remove_product: function (state,priceVariation) {
            state.selected_price_variation = priceVariation;
            state.show_dialog_box = true;
        },
        hide_dialog_box:function (state) {
            state.selected_price_variation = null;
            state.show_dialog_box = false;
        },
        update_cart_data(state,data){
            state.cartData=data;
        }
    },
    actions:{
        approve: function ({state,commit}) {
            state.show_dialog_box = false;
            const url = Vue.prototype.$siteUrl + "/site/cart/remove_product";
            const formData = new FormData();
            formData.append('product_id', state.selected_price_variation.product_id);
            formData.append('variation_id', state.selected_price_variation.id);
            formData.append('param1_id', state.selected_price_variation.param1_id);
            formData.append('param2_id', state.selected_price_variation.param2_id);
            state.progress=true;
            Vue.axios.post(url, formData).then(response => {
                state.progress=false;
                if (response.data !== "error") {
                     commit('update_cart_data',response.data);
                     vm.$root.$emit('update-cart');
                }
            }).catch(error => {
                state.progress=false;
            });
        },
        change_product_count:function ({state,commit},obj) {
            let count=0;
            if(obj.type==='plus'){
                count=(parseInt(obj.priceVariation.product_count)+1);
            }
            else {
                count=(parseInt(obj.priceVariation.product_count)-1);
            }
            if(count>0){
                state.progress=true;
                const priceVariation=obj.priceVariation;
                const url = Vue.prototype.$siteUrl + "/site/cart/change_product_cart";
                const formData = new FormData();
                formData.append('variation_id', priceVariation.id);
                formData.append('product_id', priceVariation.product_id);
                formData.append('product_count', count);
                formData.append('param1_id', priceVariation.param1_id);
                formData.append('param2_id', priceVariation.param2_id);

                Vue.axios.post(url, formData).then(response => {
                    state.progress=false;
                    commit('update_cart_data',response.data);
                    Vue.$root.$emit('update-cart');

                }).catch(error => {
                    state.progress=false;
                });
            }
        },
        add_to_next_cart: function ({dispatch},data) {
            dispatch('approve_add_to_next_cart',data);
        },
        approve_add_to_next_cart:function ({state,commit},data) {
            state.show_next_cart_message = false;
            document.getElementById('loading_box').style.display = 'block';
            const url = Vue.prototype.$siteUrl + "/site/cart/change_cart_product_type";
            const formData = new FormData();
            formData.append('price_variation_id',data[0]);
            formData.append('where_type',data[2]);
            formData.append('type', data[1]);
            Vue.axios.post(url, formData).then(response => {
                document.getElementById('loading_box').style.display = 'none';
                if (this.where_type == 'whereNotIn') {
                    window.location.href = this.$siteUrl + '/shipping';
                } else {
                    commit('update_cart_data',response.data);
                }
            }).catch(error => {
                document.getElementById('loading_box').style.display = 'none';
                if (error.response.status == 401) {
                    window.location.href = this.$siteUrl + '/login';
                }
            });
        },
        add_submission_to_next_cart:function ({state,dispatch},payload) {
            let String='';
            let i=0;
            if(payload[0]['product_key']!=undefined){
                for (let key in payload[0]['product_key']){
                    const product_key=payload[0]['product_key'][key];
                    const priceVariation=state.cartData.products[state.cart_type][product_key];
                    if(priceVariation){
                        String=String+priceVariation.id;
                        if(i!=(payload[0]['product_key'].length-1)){
                            String=String+",";
                        }
                        i++;
                    }
                }
            }
            if(String!=''){
                const data=payload;
                data[0]=String;
                dispatch('approve_add_to_next_cart',data);
            }
        }
    }
}
