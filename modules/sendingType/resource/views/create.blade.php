@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت انواع ارسال','url'=>url('admin/setting/sending_type')],
            ['title'=>'افزودن نوع ارسال جدید','url'=>url('admin/setting/sending_type/create')]
        ]])

        <?php
           $args=[];
           $args['title']='افزودن نوع ارسال جدید';
        ?>

        <x-panel-box :args="$args">

            @include('sendingType::_form',['type'=>'create'])

        </x-panel-box>

    </div>

@endsection


