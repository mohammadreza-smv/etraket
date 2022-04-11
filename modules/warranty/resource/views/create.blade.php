@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
           ['title'=>'مدیریت گارانتی ها','url'=>url('admin/warranties')],
           ['title'=>'افزودن گارانتی جدید','url'=>url('admin/warranties/create')]
        ]])


        <?php
            $args=[];
            $args['title']='افزودن گارانتی جدید';
        ?>

        <x-panel-box :args="$args">

            @include('warranty::_form',['type'=>'create'])

        </x-panel-box>

    </div>

@endsection
