<template>
    <div>
        <div class="checkout_item">
            <div :class="[(priceVariation.product_count==0 || priceVariation.product.status!=1) ? 'cart_product_image available_filter' : 'cart_product_image']">

                <img v-bind:src="$siteUrl+'/files/thumbnails/'+priceVariation.product.image_url">

                <div class="quantity-selector"  v-if="parseInt(priceVariation.product_count)>0 && parseInt(priceVariation.product.status)===1">

                    <v-icon  :class="(
                                priceVariation.product_number_cart==priceVariation.product_count ||   priceVariation.product_number<=priceVariation.product_count
                                ) ? 'displayed' : ''"
                            @click="$store.dispatch('CartStore/change_product_count',{'priceVariation':priceVariation,'type':'plus'})"
                    >
                        mdi-plus
                    </v-icon>

                    <span>
                        {{ replaceNumber(priceVariation.product_count) }}
                    </span>

                    <v-icon v-if="parseInt(priceVariation.product_count)===1" @click="$store.commit('CartStore/remove_product',priceVariation)">
                        mdi-delete-outline
                    </v-icon>

                    <v-icon v-else @click="$store.dispatch('CartStore/change_product_count',{'priceVariation':priceVariation,'type':'minus'})">
                        mdi-minus
                    </v-icon>

                </div>

                <div v-else class="available_product">
                    ناموجود
                </div>


            </div>

            <div class="cart_product_info">

                <a @click="goToProductPage(priceVariation.product)" style="color:black">{{ priceVariation.product.title }}</a>

                <div v-for="(array,key) in priceVariation.price_params" class="cart_color_div">

                    <span v-if="array['title']!=undefined">
                        {{ array['title'] }} :
                    </span>

                    <span>{{ array['value'] }}</span>

                    <span v-if="array['colorCode']!=undefined" class="ui_variant_shape" v-bind:style="{background:'#'+array['colorCode']}"></span>

                </div>

                <span v-if="priceVariation.product_count>0" class="cart_product_price"> {{ replaceNumber(number_format(priceVariation.price2)) }} تومان</span>

                <slot v-if="(priceVariation.product_count>0 && priceVariation.product.status===1)"></slot>

            </div>
        </div>

    </div>
</template>

<script>
    import myMixin from "../../../../../../resources/js/myMixin";
    export default {
        name: "MobileCartProductInfo",
        props:['priceVariation','cartType'],
        mixins:[myMixin],
        mounted() {
            this.$emit('set_changes_price',this.priceVariation);
        },
        watch:{
            priceVariation:function () {
                this.$emit('set_changes_price',this.priceVariation);
            }
        },
        methods:{
            goToProductPage:function (product) {
                let url=this.$store.state.shop_product_url;
                url=url.replace(':id',product.id);
                url=url.replace(':product_url',product.product_url);
                this.$root.$emit('send_get_request',url);
            }
        }
    }
</script>
