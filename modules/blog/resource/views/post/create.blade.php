@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت پست ها','url'=>url('admin/blog/posts')],
            ['title'=>'افزودن پست جدید','url'=>url('admin/blog/posts/create')]
        ]])

        <?php
            $args=[];
            $args['title']='افزودن پست جدید';
        ?>

        <x-panel-box :args="$args">

            @include('blog::post._form',['type'=>'create'])

        </x-panel-box>

    </div>

@endsection
