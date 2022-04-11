<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_url" content="{{ url(('/')) }}">
    <title>{{ config('shop-info.shop_name') }}</title>
    {{ add_css_file('desktop') }}
    @yield('seo')
    <link href="{{ asset('themes/theme1/mobile.css?id=ussssej') }}" rel="stylesheet"/>
    <link href="{{ asset('themes/theme1/main.css?id=psjk') }}" rel="stylesheet"/>
    <link href="{{ asset('css/widgets.css?id='.config('cms.widgetId')) }}" rel="stylesheet">
    <meta name="theme-color" content="#B3E5FC" />
</head>
<body>

<div id="app">



    <v-app class="app-style">

          @includeIf('front-theme::include.mobile-app-bar')

          <mobile-progress-box ref="progress_box"></mobile-progress-box>

          <v-main>
              <app-content>
                  @yield('content')
              </app-content>

              @include('position_view',['name'=>'mobile_layout','type'=>'content'])
          </v-main>
{{--        <div class="navbar">--}}

{{--            <mobile-header-search></mobile-header-search>--}}

{{--            <div>--}}
{{--                @includeIf('cart::mobile-header-cart')--}}

{{--                @if(Auth::check())--}}
{{--                    <a href="{{ url('user/profile') }}"><span class="fa fa-user-o"></span></a>--}}
{{--                @else--}}
{{--                    <a href="{{ url('login') }}"><span class="fa fa-user-o"></span></a>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}




        <div>
            @includeIf('themes::widgets.view',['location'=>'mobile_layout_footer'])
        </div>
    </v-app>



</div>


<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
