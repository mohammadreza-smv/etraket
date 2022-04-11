<mobile-other-price-variation :product_id="{{ $product->id }}">
    <template v-slot:variation-list-detail="{variation}">
        @include('position_view',['name'=>'product_variation_list_params'])
    </template>
</mobile-other-price-variation>
