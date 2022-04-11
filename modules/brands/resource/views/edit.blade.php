@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
           ['title'=>'مدیریت برند ها','url'=>url('admin/brands')],
           ['title'=>'ویرایش برند','url'=>url('admin/brands/'.$brand->id.'/edit')]
        ]])


        <?php
            $args=[];
            $args['title']='ویرایش برند - '.e($brand->brand_name);
        ?>


        <x-panel-box :args="$args">
            @include('brands::_form',['type'=>'edit'])
        </x-panel-box>

    </div>

@endsection
