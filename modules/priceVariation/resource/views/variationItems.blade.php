@if(!isset($type) || $type=='select')

    <?php
        $property='param'.$num.'_id';
        $relation='param'.$num;
        $param_key='param'.$num.'_type'
    ?>
    <div style="padding-bottom: 20px;padding-top:20px">
        @if($product->PriceVariation[0]->$relation)
            <span>انتخاب {{ $product->PriceVariation[0]->$relation->variation_name }}</span>
            <?php
                $select_id=$num=="1" ? $param1_id : $param2_id;
            ?>

            <select-item
                :price_variation="{{ json_encode($product->PriceVariation) }}"
                property="{{ $property }}"
                param_key="{{ $param_key }}"
                num="{{ $num }}"
                relation="{{ $relation }}"
                select_id="{{ $select_id }}"
            ></select-item>
        @endif
    </div>

@endif
