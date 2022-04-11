@extends('sellers::layouts.panel')

@section('content')


    <div>

        <?php
             $args1=['title'=>'نمودار میزان فروش این ماه فروشگاه'];
             $args2=['title'=>'آخرین سفارشات شما'];
        ?>

        <div style="margin:15px">
            @if($seller->account_status=='awaiting_approval')
                <v-alert type="error">
                    در انتظار تایید حساب کاربری
                </v-alert>
            @endif

            @if($seller->account_status=='Inactive')
                <v-alert type="error">
                    حساب کاربری شما غیر فعال می باشد
                </v-alert>
            @endif
        </div>


        <x-seller-panel-box :args="$args1">
            <month-sales-statistics></month-sales-statistics>
        </x-seller-panel-box>


        <x-seller-panel-box :args="$args2">
            @includeIf('sellers::panel.orders.list',['orders'=>$latsOrders])
        </x-seller-panel-box>

    </div>


@endsection
