@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
        ['title'=>'مدیریت انبار ها','url'=>url('admin/stockrooms')],
        ['title'=>'خروج محصول از انبار','url'=>url('admin/stockroom/add/output')]
    ]])
    <div class="panel">

        <div class="header">
            افزودن لیست خروج محصول از انبار
        </div>

        <div class="panel_content">

            <stockroom-output-list :stockroom='{{ $stockroom }}'></stockroom-product-list>
            
        </div>
    </div>

@endsection
