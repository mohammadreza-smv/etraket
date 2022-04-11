@if(isset($product))
    <shop-detail :product="{{ $product }}"></shop-detail>
@else
    <shop-detail :product="product"></shop-detail>
@endif

