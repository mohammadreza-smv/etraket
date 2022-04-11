@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت دسته ها','url'=>url('admin/category-common-question')],
            ['title'=>'افزودن دسته جدید','url'=>url('admin/category-common-question/create')]
        ]])

        <?php
           $args=[];
           $args['title']='افزودن دسته جدید برای پرسش های متداول';
        ?>

        <x-panel-box :args="$args">

            @include('faq::category_common_question._form',['type'=>'create'])

        </x-panel-box>

    </div>

@endsection
