@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت اسلایدر ها','url'=>url('admin/sliders')],
            ['title'=>'ویرایش اسلایدر','url'=>url('admin/sliders/'.$slider->id.'/edit')]
        ]])

        <?php
        $args=[];
        $args['title']='ویرایش اسلایدر - '.e($slider->title);
        ?>


        <x-panel-box :args="$args">

            @include('sliders::panel._form',['type'=>'edit'])

        </x-panel-box>


    </div>

@endsection
