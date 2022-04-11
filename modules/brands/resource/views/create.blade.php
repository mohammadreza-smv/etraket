@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت برند ها','url'=>url('admin/brands')],
            ['title'=>'افزودن برند جدید','url'=>url('admin/brands/create')]
        ]])

        <?php
            $args=[];
            $args['title']='افزودن برند جدید';
        ?>

        <x-panel-box :args="$args">

            @include('brands::_form',['type'=>'create'])

        </x-panel-box>

    </div>
@endsection
