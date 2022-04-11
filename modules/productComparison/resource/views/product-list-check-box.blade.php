@if(isset($product))
    <comparison-checkbox
       id="{{ $product->id }}"
       title="{{ $product->title }}"
       image_url="{{ $product->image_url }}"
    ></comparison-checkbox>
@else
    <comparison-checkbox
        :id="product.id"
        :title="product.title"
        :image_url="product.image_url"
    ></comparison-checkbox>
@endif

