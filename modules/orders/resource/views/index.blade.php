@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت سفارشات','url'=>url('admin/orders')]]])

        @includeIf('orders::search-box')

        @includeIf('orders::order-list')

    </div>

@endsection
