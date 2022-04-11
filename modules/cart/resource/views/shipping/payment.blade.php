@extends('cart::layouts.order')

@section('content')

    <div>
        <order-steppers step="2">

            <template v-slot:header>
                <img src="{{ asset(config('shop-info.shop_icon')) }}" class="shop_icon">
            </template>

        </order-steppers>

        <payment-box
            price="{{ get_price($send_order_data['final_price'][1][$send_type]) }}" token="{{ csrf_token() }}">

            <template v-slot:message>
                @if(Session::has('error'))
                    <v-alert type="error">{{ Session::get('error') }}</v-alert>
                @endif
            </template>

            <template v-slot:paymentitems>
                <v-radio :value="1" label="پرداخت اینترنتی (آنلاین با تمامی کارت های بانکی)"></v-radio>
            </template>

            <template v-slot:content>
                <div>
                    <h4>خلاصه سفارش</h4>
                </div>

                @includeIf('cart::checkout-products')

                @include('position_view',['name'=>'payment_page',
                     'args'=>[
                         'order_price'=>$send_order_data['final_price'][1][$send_type]]
                     ])

            </template>

            <template slot="factor">
                @includeIf('cart::checkout-items')
            </template>

        </payment-box>

    </div>

@endsection


