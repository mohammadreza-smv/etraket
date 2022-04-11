<template>
    <tr>
        <td :class="[priceVariation.product_count===0 ? 'available_filter' : '']">
            <img v-bind:src="$siteUrl+'/files/thumbnails/'+priceVariation.product.image_url">
        </td>
        <td>
            <ul>
                <li class="title">
                    <a v-bind:href="$siteUrl+'/product'+$productUrlParam+priceVariation.product.id+'/'+priceVariation.product.product_url">{{ priceVariation.product.title }}</a>
                </li>
                <li v-for="(array,key) in priceVariation.price_params">


                    <span v-if="array['colorCode']!==undefined"  class="ui_variant_shape" v-bind:style="{background:'#'+array['colorCode']}"></span>

                    <span v-if="array['title']!=undefined">
                        {{ array['title'] }} :
                    </span>

                    <span>{{ array['value'] }}</span>


                </li>
                <li v-if="priceVariation.product_count==0">
                    <div class="available_product">
                        ناموجود
                    </div>
                </li>
                <li v-else style="display: flex;justify-content: space-between">
                    <span>
                        <span>تعداد : </span> {{ replaceNumber(priceVariation.product_count) }}
                    </span>

                    <a  v-bind:href="$siteUrl+'/Cart'" >
                        <span class="fa fa-trash-o"></span>
                    </a>
                </li>
            </ul>
        </td>
    </tr>
</template>

<script>
    import myMixin from "../../../../../../resources/js/myMixin";
    export default {
        name: "HeaderCartProductInfo",
        props:['priceVariation'],
        mixins:[myMixin],
    }
</script>


