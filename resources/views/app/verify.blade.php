<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_url" content="{{ url(('/')) }}">
    <title>فروشگاه {{ config('shop-info.shop_name') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mobile_app.css') }}" rel="stylesheet">
</head>
<body>

<div id="app">

    <div class="header">
        <a href="{{ url('/') }}">
            <span>فروشگاه اینترنتی {{ config('shop-info.shop_name') }}</span>
        </a>
    </div>

    <div class="message_box">
        @if(isset($error_payment))

            <h5>
                پرداخت انجام نشد
            </h5>
            <p>
                {{ $error_payment }}
            </p>
        @else

            <h5>
                سفارش {{ replace_number($order->order_id) }} با موفقیت پرداخت و ثبت شد
            </h5>
            <p>
                پرداخت سفارش شما با موفقیت انجام شده و در زمان تعیین شده ارسال سفارش انجام خواهد شد
            </p>

        @endif

        <a  class="btn btn-success">
            مشاهده اپلیکیشن
        </a>

    </div>

</div>

</body>
</html>
