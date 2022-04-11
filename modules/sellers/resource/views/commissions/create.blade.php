@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
           ['title'=>'مدیریت کمیسیون ها','url'=>url('admin/sellers/commissions')],
           ['title'=>'افزودن کمیسیون','url'=>url('admin/sellers/commissions/create')]
       ]])

        <?php
            $args=[];
            $args['title']='افزودن کمیسیون';
        ?>

        <x-panel-box :args="$args">
            @include('sellers::commissions._form',['type'=>'create'])
        </x-panel-box>

    </div>

@endsection
