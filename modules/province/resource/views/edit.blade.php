@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
              ['title'=>'مدیریت استان ها','url'=>url('admin/province')],
              ['title'=>'ویرایش استان','url'=>url('admin/province/'.$province->id.'/edit')]
        ]])

        <?php
           $args=[];
           $args['title']='ویرایش نام استان - '.e($province->name);
        ?>

        <x-panel-box :args="$args">
            @include('province::_form',['type'=>'edit'])
        </x-panel-box>


    </div>

@endsection
