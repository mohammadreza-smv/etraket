@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت گارانتی ها','url'=>url('admin/warranties')],
            ['title'=>'ویرایش گارانتی','url'=>url('admin/warranties/'.$warranty->id)]
        ]])

        <?php
           $args=[];
           $args['title']='ویرایش گارانتی - '.e($warranty->name);
        ?>

        <x-panel-box :args="$args">
            @include('warranty::_form',['type'=>'edit'])
        </x-panel-box>


    </div>

@endsection

