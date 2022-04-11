@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت رنگ ها','url'=>url('admin/colors')],
            ['title'=>'افزودن رنگ جدید','url'=>url('admin/colors/create')]
        ]])

        <?php
            $args=[];
            $args['title']='افزودن رنگ جدید';
        ?>

        <x-panel-box :args="$args">
            @include('colors::_form',['type'=>'create'])
        </x-panel-box>

    </div>

@endsection


