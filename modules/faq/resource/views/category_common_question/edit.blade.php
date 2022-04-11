@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت دسته ها','url'=>url('admin/category-common-question')],
            ['title'=>'ویرایش دسته','url'=>url('admin/category-common-question/'.$CategoryCommonQuestion->id.'/edit')]
        ]])

        <?php
           $args=[];
           $args['title']='ویرایش دسته - '.e($CategoryCommonQuestion->title);
        ?>


        <x-panel-box :args="$args">
            @include('faq::category_common_question._form',['type'=>'edit'])
        </x-panel-box>

    </div>

@endsection
