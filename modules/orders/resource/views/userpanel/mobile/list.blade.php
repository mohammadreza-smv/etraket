@extends('front-theme::layouts.mobile.user-panel')

@section('panel-content')

    <?php $args=['title'=>'تاریخچه سفارشات'] ?>

    <x-user-panel-box :args="$args">

        <div class="order-category-tab">

            <?php
            $shop_product_url=shop_product_url_theme();
            $orderCount=[
                'wait_for_payment'=>$wait_for_payment,
                'paid_in_progress'=>$paid_in_progress,
                'delivered'=>$delivered,
                'returned'=>$returned,
                'canceled'=>$canceled
            ]
            ?>

            <user-panel-order-list
                    :orders="{{ json_encode($orders) }}"
                    shop_product_url="{{ $shop_product_url }}"
                    delivered="{{ $delivered }}"
                    :order_count="{{ json_encode($orderCount) }}"
                >

            </user-panel-order-list>


        </div>
    </x-user-panel-box>

@endsection



