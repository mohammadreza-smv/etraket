@extends('front-theme::layouts.mobile-app')

@section('content')

    <?php

        $login=Auth::check() ? 'true' : 'false';

        $shop_product_url=shop_product_url_theme();

    ?>

    <mobile-shopping-cart
        :cart_data="{{ json_encode($cart_data) }}"
        :login_status="{{ $login }}"
        shop_product_url="{{ $shop_product_url }}"
    >

        <template v-slot:loading_box>
            <a href="{{ url('') }}">
                <img  src="{{ asset(config('shop-info.shop_icon')) }}" class="loading-logo">
            </a>
        </template>

    </mobile-shopping-cart>

@endsection
