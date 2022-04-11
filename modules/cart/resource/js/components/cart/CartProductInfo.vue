<template>
    <tr>
        <td>
            <div @click="$store.commit('CartStore/remove_product',priceVariation)">
                <v-icon
                    color="#ef5661"
                >
                    mdi-delete
                </v-icon>
            </div>
        </td>
        <td :class="[(parseInt(priceVariation.product_count)===0 || parseInt(priceVariation.product.status)!==1) ? 'available_filter' : '']">
            <img v-bind:src="$siteUrl+'/files/thumbnails/'+priceVariation.product.image_url">
        </td>
        <td>
            <ul>
                <li class="title">
                    <a @click="goToProductPage(priceVariation.product)" style="color:black">
                        {{ priceVariation.product.title }}
                    </a>
                </li>
                <li v-for="(array,key) in priceVariation.price_params" style="display: flex">

                    <span v-if="array['title']!==undefined">
                        {{ array['title'] }} :
                    </span>

                    <span>{{ array['value'] }}</span>

                    <div v-if="array['colorCode']!==undefined" class="ui_variant_shape "
                         v-bind:style="{background:'#'+array['colorCode']}"></div>

                </li>
                <slot v-if="(priceVariation.product_count>0 && priceVariation.product.status===1)"></slot>

                <li>
                    <div class="quantity-selector" style="width:100px;margin-right:0px"  v-if="parseInt(priceVariation.product_count)>0 && parseInt(priceVariation.product.status)===1">

                        <v-icon    :class="(
                                priceVariation.product_number_cart==priceVariation.product_count ||   priceVariation.product_number<=priceVariation.product_count
                                ) ? 'displayed' : ''"
                                @click="$store.dispatch('CartStore/change_product_count',{'priceVariation':priceVariation,'type':'plus'})"
                        >
                            mdi-plus
                        </v-icon>

                        <span>
                        {{ replaceNumber(priceVariation.product_count) }}
                    </span>

                        <v-icon
                            :class="priceVariation.product_count===1 ? 'displayed' : ''"
                            @click="$store.dispatch('CartStore/change_product_count',{'priceVariation':priceVariation,'type':'minus'})">
                            mdi-minus
                        </v-icon>

                    </div>

                    <div v-else class="available_product">
                        ناموجود
                    </div>
                </li>
            </ul>


        </td>
        <td>
            <div v-if="priceVariation.product_count>0">
                {{ replaceNumber(number_format(priceVariation.price2)) }} تومان
            </div>
        </td>
    </tr>
</template>

<script>
    import cartEvent from "../../cartEvent";
    export default {
        name: "CartProductInfo",
        props:['priceVariation',],
        mixins:[cartEvent],
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

