@extends('sellers::layouts.auth')

@section('content')

    <seller-register shop_name="{{ config('shop-info.shop_name') }}">

        <template slot="register-1">
            @include('sellers::auth.register.step1')

            <p style="margin-top:50px;text-align:center">
                <span>قبلاً ثبت نام کرده‌ام.</span>
                <a href="{{ url('sellers/login') }}" class="router-link c-link">
                    ورود
                </a>
            </p>

            <v-alert type="error" border="left"  colored-border>

                توجه: در صورتی که مراحل ثبت نام را نیمه تمام گذاشته اید، می توانید با همان شماره موبایل ثبت نام خود را ادامه دهید.

            </v-alert>


        </template>

        <template v-slot:register-2="{mobile}">
            @include('sellers::auth.register.step2')
        </template>

        <template v-slot:register-3="{mobile}">
            <register-active-code :mobile="mobile"></register-active-code>
        </template>

        <template v-slot:upload-file-1="{mobile}">
            @include('sellers::auth.register.step4_1')
        </template>

        <template v-slot:upload-file-2="{mobile}">
            @include('sellers::auth.register.step4_2')
        </template>

    </seller-register>

@endsection
