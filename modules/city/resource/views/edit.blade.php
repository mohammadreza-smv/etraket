@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت شهر ها','url'=>url('admin/city')],
            ['title'=>'ویرایش شهر','url'=>url('admin/city/'.$city->id.'/edit')]
        ]])


        <?php
            $args=[];
           $args['title']='ویرایش شهر - '.e($city->name);
        ?>


        <x-panel-box :args="$args">
            @include('city::_form',['type'=>'edit'])
        </x-panel-box>

    </div>

@endsection
