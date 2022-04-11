@if(!isset($filter_array))
    <?php $filter_array=[] ?>
@endif

@if(!isset($filters))
    <?php
       $filters=[];
       $product_filters=[];
    ?>
@endif

<select-filter-for-product-item
    :item="slotProps.item"
    default_component="{{ $path }}"
    :filter_array="{{ json_encode($filter_array) }}"
    :filters="{{ json_encode($filters) }}"
    :product_filters="{{ json_encode($product_filters) }}"
>

</select-filter-for-product-item>
