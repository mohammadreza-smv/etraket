@extends('backend-theme::layout')

@section('content')

    @include('include.breadcrumb',['data'=>[
        ['title'=>'مدیریت محموله ها','url'=>url('admin/packages')],
        ['title'=>'جزییات محموله','url'=>url('admin/packages/'.$package->id)]]]
    )
    <div class="panel">

        <div class="header">
            جزییات محموله - {{ $package->package_id }}
        </div>
        @php
            $status=[-2=>'ارسال ناقص',-1=>'عدم ارسال',0=>'آماده ارسال',1=>'ارسال شده'];
        @endphp
        <div class="panel_content">
            <package-content :package_id="{{ $package->id }}" :status="{{ $package->status }}"  :stockroom_id="{{ $package->stockroom_id }}" :seller_tozihat='"{{ $package->tozihat }}"'  :stockroom='"{{ $package->getStockroom->name }}"'></package-content>
        </div>
    </div>

@endsection
