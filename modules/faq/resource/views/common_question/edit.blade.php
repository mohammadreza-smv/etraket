@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت پرسش ها','url'=>url('admin/common-question')],
            ['title'=>'ویرایش پرسش','url'=>url('admin/common-question/'.$CommonQuestion->id)]
        ]])

        <?php
           $args=[];
           $args['title']='ویرایش پرسش - '.e($CommonQuestion->title);
        ?>


        <x-panel-box :args="$args">

            @include('faq::common_question._form',['type'=>'edit'])

        </x-panel-box>


    </div>

@endsection


