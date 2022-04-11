@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت دسته ها','url'=>url('admin/blog/categories')],
            ['title'=>'افزودن دسته جدید','url'=>url('admin/blog/categories/create')]
        ]])


        <?php
            $args=[];
            $args['title']='افزودن دسته جدید';
        ?>

        <x-panel-box :args="$args">

            @include('blog::category._form',['type'=>'create'])

        </x-panel-box>

    </div>

@endsection
