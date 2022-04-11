<mobile-theme-question-list
    product_id="{{ $product->id }}"
    shop_name="{{ config('shop-info.shop_name') }}"
    auth="{{ Auth::check() ? 'ok' : 'no' }}"
></mobile-theme-question-list>
