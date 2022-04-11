@if($variation->offers_last_time>time() && $variation->offers==1)
    <offer-time second="{{ ($variation->offers_last_time-time()) }}"></offer-time>
@endif


