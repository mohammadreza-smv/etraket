<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>بازیابی کلمه عبور</title>
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

            <seller-forgot-password>

                <template slot="login-right-box">

                    <div>
                        <img src="{{ url(config('shop-info.shop_icon')) }}">
                        <h5>به مرکز فروشندگان {{ config('shop-info.shop_name') }} خوش آمدید</h5>
                    </div>

                </template>

                <template slot="content">
                    @yield('content')

                    <a href="{{ url('sellers/login') }}" class="router-link c-link">
                        ورود به پنل فروشندگان
                    </a>
                </template>

            </seller-forgot-password>

        </app-content>
    </v-app>
</div>

<?php registerVueFile('','ssr',config('cms.develop')) ?>

</body>
</html>
