<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_url" content="{{ url(('/')) }}">
    <title>فروشگاه {{ config('shop-info.shop_name') }}</title>
    {{ add_css_file('') }}
    <link href="{{ url('modules/users/style.css?id=new') }}" rel="stylesheet">
</head>
<body>

<div id="app">

    <v-app>
       <app-content>
           @yield('content')
       </app-content>
    </v-app>

</div>

<?php registerVueFile('') ?>


</body>
</html>