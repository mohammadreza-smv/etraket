@extends('sellers::layouts.auth')

@section('content')

    <seller-forgot-password>
        <template slot="login-right-box">

            <div>
                <img src="{{ url(config('shop-info.shop_icon')) }}">
                <h5>به مرکز فروشندگان {{ config('shop-info.shop_name') }} خوش آمدید</h5>
            </div>

        </template>

        <template slot="content">
            <a href="{{ url('sellers/login') }}" class="router-link c-link">
                ورود به پنل فروشندگان
            </a>
        </template>

    </seller-forgot-password>

@endsection
