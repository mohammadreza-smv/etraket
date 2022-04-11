@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت پرسش ها','url'=>url('admin/common-question')],
            ['title'=>'افزودن پرسش جدید','url'=>url('admin/common-question/create')]
        ]])

        <?php
           $args=[];
           $args['title']='افزودن پرسش جدید';
        ?>

        <x-panel-box :args="$args">

            @include('faq::common_question._form',['type'=>'create'])

        </x-panel-box>

    </div>

@endsection

