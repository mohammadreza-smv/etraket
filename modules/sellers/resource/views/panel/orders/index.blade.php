@extends('sellers::layouts.panel')

@section('content')


    <div>

        @include('sellers::panel.breadcrumb',['data'=>[
             ['title'=>'مدیریت سفارشات','url'=>url('sellers/panel/orders')],
        ]])

        <?php
            $args1=['title'=>'مدیریت سفارشات'];
        ?>

        @includeIf('sellers::panel.orders._search_form')

        <x-seller-panel-box :args="$args1">

            @includeIf('sellers::panel.orders.list')

            {{ $orders->links() }}

        </x-seller-panel-box>

    </div>

@endsection
