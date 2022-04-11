@extends('backend-theme::layout')

@section('content')

    <div>

         @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت رنگ ها','url'=>url('admin/colors')],
             ['title'=>'ویرایش رنگ','url'=>url('admin/colors/'.$color->id.'/edit')]
         ]])

        <?php
            $args=[];
            $args['title']='ویرایش رنگ - '.e($color->name);
        ?>

        <x-panel-box :args="$args">
            @include('colors::_form',['type'=>'edit'])
        </x-panel-box>

    </div>

@endsection


