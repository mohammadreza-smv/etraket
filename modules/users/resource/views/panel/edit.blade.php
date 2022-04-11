@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت کاربران','url'=>url('admin/users')],
            ['title'=>'ویرایش اطلاعات کاربر','url'=>url('admin/users/'.$user->id.'/ediy')]
        ]])

        <?php
        $args=[];
        $args['title']='ویرایش اطلاعات کاربر - '.e($user->mobile);
        ?>


        <x-panel-box :args="$args">

            @include('users::panel._form',['type'=>'edit'])

        </x-panel-box>


    </div>

@endsection
