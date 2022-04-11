<?php
$property='param'.$num.'_id';
$relation='param'.$num;
$selected=false;
?>

@if(!isset($type) || $type!='select')
    @if($num==2)
        @foreach($product->PriceVariation as $variation)
            @if($param1_id==$variation->param1_id && $param2_id==$variation->param2_id && !$selected)
                @if($variation->$relation)
                    <?php $selected=true; ?>
                    <div class="info_item_product">
                        <div>
                            <v-icon>mdi-shield-star</v-icon>
                            {{ $variation->$relation->name }}
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    @else
        @foreach($product->PriceVariation as $variation)
            @if($price_variation->param1_id==$variation->param1_id  && !$selected)
                @if($variation->$relation)
                    <?php $selected=true; ?>
                    <div class="info_item_product">
                        <div>
                            <v-icon>mdi-shield-star</v-icon>
                            {{ $variation->$relation->name }}
                        </div>
                    </div>
                @endif

            @endif
        @endforeach
    @endif

@endif
