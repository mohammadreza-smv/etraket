@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت استان ها','url'=>url('admin/province')],
             ['title'=>'افزودن استان جدید','url'=>url('admin/province/create')]
        ]])

        <?php
            $args=[];
            $args['title']='افزودن استان جدید';
        ?>

        <x-panel-box :args="$args">
            @include('province::_form',['type'=>'create'])
        </x-panel-box>

    </div>

@endsection
