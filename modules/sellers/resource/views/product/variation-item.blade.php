<?php
    $seller=$price_variation->seller;
    $brand_name=$seller->brand_name;
    config()->set('seller_component','add');
?>
<div>
    <a style="color: black"
        @if($seller->id>0) href="{{ url('seller/'.$seller->id) }}"  @endif
        target="_blank" class="info_item_product">
        <div>
            <v-icon>mdi-home</v-icon>
            {{ $brand_name  }}
        </div>
        <div>
            <v-icon>mdi-chevron-left</v-icon>
        </div>
    </a>
</div>
