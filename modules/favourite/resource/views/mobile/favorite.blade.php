@extends('front-theme::layouts.mobile.user-panel')


@section('panel-content')

    <?php $args=['title'=>'لیست علاقه مندی ها'] ?>

    <x-user-panel-box :args="$args">

        <?php
            $shop_product_url=shop_product_url_theme();
        ?>
        <mobile-favorite-list
            shop_product_url="{{ $shop_product_url }}"
        >
            <template v-slot:loading_box>
                <a href="{{ url('') }}">
                    <img  src="{{ asset(config('shop-info.shop_icon')) }}" class="favorite-loading-logo">
                </a>
            </template>
        </mobile-favorite-list>
    </x-user-panel-box>

@endsection
