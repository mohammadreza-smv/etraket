@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت شهر ها','url'=>url('admin/city')],
            ['title'=>'افزودن شهر جدید','url'=>url('admin/city/create')]
        ]])

        <?php
           $args=[];
           $args['title']='افزودن شهر جدید';
        ?>

        <x-panel-box :args="$args">
            @include('city::_form',['type'=>'create'])
        </x-panel-box>

    </div>

@endsection

