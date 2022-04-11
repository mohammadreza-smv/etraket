@if(isset($product))
    <product-color-list :product="{{ $product }}"></product-color-list>
@else
    <product-color-list :product="product"></product-color-list>
@endif

