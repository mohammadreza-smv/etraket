@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت انواع ارسال مرسوله ','url'=>url('admin/setting/sending_type')],
            ['title'=>'ویرایش اطلاعات نوع ارسال','url'=>url('admin/setting/sending_type/'.$send_type->id.'/edit')]
        ]])

        <?php
            $args=[];
            $args['title']='ویرایش اطلاعات نوع ارسال - '.e($send_type->type_name);
        ?>


        <x-panel-box :args="$args">
            @include('sendingType::_form',['type'=>'edit'])
        </x-panel-box>

    </div>

@endsection


