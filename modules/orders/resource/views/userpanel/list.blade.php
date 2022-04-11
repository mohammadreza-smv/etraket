@extends('front-theme::layouts.user-panel')

@section('panel-content')

    <?php $args=['title'=>'تاریخچه سفارشات']; ?>

    <x-user-panel-box :args="$args">

        <div class="order-category-tab">

            <?php
                $shop_product_url=shop_product_url_theme();
                $orderTypes=[];
                $types=user_panel_submission_types();
                foreach ($types as $key=>$type){
                    $count=${$key};
                    $orderTypes[$key]=['count'=>$count,'title'=>$type['title']];
                }
            ?>
            <user-panel-order-list
                :orders="{{ json_encode($orders) }}"
                shop_product_url="{{ $shop_product_url }}"
                delivered="{{ $delivered }}"
                :order_types="{{ json_encode($orderTypes) }}"
            >

            </user-panel-order-list>

        </div>

    </x-user-panel-box>

@endsection
