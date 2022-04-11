@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت اسلایدر ها','url'=>url('admin/sliders')],
            ['title'=>'افزودن اسلایدر جدید','url'=>url('admin/brands/sliders')]
        ]])

        <?php
            $args=[];
            $args['title']='افزودن اسلایدر جدید';
        ?>

        <x-panel-box :args="$args">

            @include('sliders::panel._form',['type'=>'create'])

        </x-panel-box>

    </div>

@endsection
