@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
           ['title'=>'مدیریت فروشگان','url'=>url('admin/sellers/list')],
           ['title'=>'ویرایش اطلاعات فروشنده','url'=>url('admin/sellers/list/'.$seller->id.'/edit')]
       ]])

        <?php
        $args=[];
        $args['title']='  ویرایش اطلاعات فروشنده - '.e($seller->brand_name);
        ?>

        <x-panel-box :args="$args">
            @include('sellers::_form',['type'=>'edit'])
        </x-panel-box>

    </div>

@endsection
