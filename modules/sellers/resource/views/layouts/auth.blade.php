<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $page_title  }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_url" content="{{ url(('/')) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('modules/sellers/sellers.css?id=fddf') }}" rel="stylesheet">
    {{ add_css_file('desktop') }}
</head>
<body>

<div id="app">
    <v-app class="app-style">
        <app-content>
            @yield('content')
        </app-content>
    </v-app>
</div>

<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
