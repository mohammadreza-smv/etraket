@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت صفحات','url'=>url('admin/pages')],
             ['title'=>'افزودن صفحه جدید','url'=>url('admin/pages/create')]
        ]])

        <?php
           $args=[];
           $args['title']='افزودن صفحه جدید';
        ?>
        <x-panel-box :args="$args">
            @include('pages::panel._form',['type'=>'create'])
        </x-panel-box>

    </div>

@endsection

