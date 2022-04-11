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
    <link rel="stylesheet" href="{{ asset('modules/blog/style.css?id='.time()) }}"/>
    <link href="{{ asset('css/widgets.css?id='.config('cms.widgetId')) }}" rel="stylesheet">
</head>
<body>

<div id="app">

    <div id="app-body">
        <v-app class="app-style">

            @include('blog::header')

            <app-content>
                @yield('content')
            </app-content>

        </v-app>
    </div>


</div>



<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
