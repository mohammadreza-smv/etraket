<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_url" content="{{ url(('/')) }}">
    @yield('seo')
    <title>{{ defined('page_title') ? page_title : config('shop-info.shop_name') }}</title>
    {{ add_css_file('desktop') }}
    @yield('head')
    <link href="{{ asset('css/shop.css?id=v3') }}" rel="stylesheet">
    <link href="{{ asset('css/widgets.css?id='.config('cms.widgetId')) }}" rel="stylesheet">
    <link href="{{ asset('themes/theme1/style.css?id=v2') }}" rel="stylesheet"/>
    <link href="{{ asset('themes/theme1/main.css?id=jasddk') }}" rel="stylesheet"/>
</head>
<body>

<div id="app">

    <div id="app-body">
        <v-app class="app-style">

            @includeIf('themes::widgets.view',['location'=>'desktop_every_page'])

            <progress-box ref="progress_box"></progress-box>

            <div class="header">

                <div class="header_row">
                    <a href="{{ url('') }}" class="router-link">
                        <img src="{{ asset(config('shop-info.shop_icon')) }}" class="shop_logo">
                    </a>

                    <header-search></header-search>
                </div>

                <div class="header_action">

                    <div style="margin-top:3px;height:39px">

                        <auth-menu login="{{ Auth::check() ? 'yes' : 'no' }}"
                                   role_id="{{ Auth::check() ? Auth::user()->role_id : 0 }}"
                                   role="{{ Auth::check() ? Auth::user()->role : '' }}"
                                   shop_name="{{ config('shop-info.shop_name') }}"
                        >
                            <v-list-item>
                                <v-list-item-icon @click="$root.$emit('send_get_request','{{ url('user/profile/orders') }}')"><v-icon>mdi-basket</v-icon></v-list-item-icon>
                                <v-list-item-title @click="$root.$emit('send_get_request','{{ url('user/profile/orders') }}')"> پیگیری سفارش</v-list-item-title>
                            </v-list-item>

                        </auth-menu>

                    </div>

                    <header-cart cart_type="1"></header-cart>
                </div>

            </div>


            @include('front-theme::views.categoryList',['catList'=>$catList])

            <app-content>
                @yield('content')
            </app-content>

            @include('position_view',['name'=>'desktop_layout','type'=>'content'])

            <footer>
                @includeIf('themes::widgets.view',['location'=>'desktop_layout_footer'])
            </footer>

        </v-app>
    </div>

    <div class="category_cover"></div>

</div>

<div id="default-loading">
    <div class="loading_div">
        <img src="{{ asset(config('shop-info.shop_icon')) }}">
        <div class="spinner">
            <div class="b1"></div>
            <div class="b2"></div>
            <div class="b3"></div>
        </div>
    </div>
</div>

<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
