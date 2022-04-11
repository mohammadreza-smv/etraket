@if(!isset($show))
    <?php  $show='vertical'; ?>
@endif

@if(isset($product))
    <product-offers-time :product="{{ $product }}" show="{{ $show }}"></product-offers-time>
@else
    <product-offers-time :product="product" show="{{ $show }}"></product-offers-time>
@endif

