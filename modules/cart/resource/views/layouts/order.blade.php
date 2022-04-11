<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_url" content="{{ url(('/')) }}">
    <title>فروشگاه {{ config('shop-info.shop_name') }}</title>
    @yield('head')
    {{ add_css_file('desktop') }}
    <link href="{{ asset('modules/cart/style.css') }}" rel="stylesheet">
</head>
<body>

<div id="app">

    <v-app>

        <request-progress>
            <template v-slot:loading_box>
                <a href="{{ url('') }}">
                    <img  src="{{ asset(config('shop-info.shop_icon')) }}" class="loading-logo">
                </a>
            </template>
        </request-progress>

        <app-content>
            @yield('content')
        </app-content>
    </v-app>

</div>



<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
