@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
           ['title'=>'مدیریت کمیسیون ها','url'=>url('admin/sellers/commissions')],
           ['title'=>'ویرایش','url'=>url('admin/sellers/commissions/'.$commission.'/edit')]
       ]])

        <?php
        $args=[];
        $args['title']='ویرایش کمیسیون';
        ?>

        <x-panel-box :args="$args">
            @include('sellers::commissions._form',['type'=>'edit'])
        </x-panel-box>

    </div>

@endsection
