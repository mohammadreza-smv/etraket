@extends('backend-theme::layout')

@section('content')

    <div>
            @include('backend-theme::breadcrumb',['data'=>[
                ['title'=>'مدیریت فروشندگان','url'=>url('admin/sellers/list')],
                ['title'=>'آمار فروش','url'=>url('admin/sellers/'.$seller->id.'statistics')]
            ]])

        <?php
            $args=['title'=>'آمار فروش - '.$seller->brand_name];
        ?>

        <x-panel-box :args="$args">
             <seller-sale-chart seller_id="{{ $seller->id }}"></seller-sale-chart>
        </x-panel-box>

    </div>
@endsection
