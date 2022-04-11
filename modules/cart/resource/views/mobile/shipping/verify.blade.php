@extends('cart::layouts.order')

@section('content')

    <div>
        <div>
            <order-steppers step="3">

                <template v-slot:header>
                    <img src="{{ asset(config('shop-info.shop_icon')) }}" class="shop_icon">
                </template>

            </order-steppers>
        </div>

        <div style="width: 99%;margin: auto">
            <div class="order-detail">

                @if($detail['status']=='error')
                    <div class="pay-status">
                        <v-icon>mdi-alert</v-icon>
                        <p>پرداخت انجام نشد</p>
                        <p>در صورتی که از حساب شما مبلغ سفارش کسر شده باشد طی ساعات آینده از طرف بانک به حساب شما برگشت داده میشود</p>

                    </div>
                @else
                    <div class="pay-status">
                        <p>سفارش <span class="order-id">
                            @if(is_array($detail) && array_key_exists('order',$detail))
                                    {{ replace_number($detail['order']->order_id) }}
                                @endif
                        </span> با موفقیت پرداخت و در سیستم ثبت شده</p>
                        <p>
                            پرداخت با موفقیت انجام شد و سفارش شما در زمان تعیین شده ارسال خواهد شده
                        </p>
                        <p>
                            از اینکه {{ config('shop-info.shop_name') }} را برای خرید انتخاب کردید از شما سپاسگذاریم
                        </p>
                    </div>
                @endif


            </div>

            @if($detail['status']=='ok')
                <div class="order-detail">
                    <div style="margin:30px 20px">

                        @if(array_key_exists('order_link',$detail))

                            <a target="_blank" style="color: white;text-decoration: none" href="{{ $detail['order_link'] }}">
                                <v-btn color="error">
                                    جزییات سفارش
                                </v-btn>
                            </a>

                        @endif

                        @if(array_key_exists('view',$detail))
                            @includeIf($detail['view'],['order'=>$detail['order']])
                        @endif

                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
