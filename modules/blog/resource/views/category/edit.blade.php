@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت دسته ها','url'=>url('admin/blog/categories')],
            ['title'=>'ویرایش دسته','url'=>url('admin/blog/categories/'.$category->id.'/edit')]
        ]])

        <?php
           $args=[];
           $args['title']='ویرایش دسته بندی - '.e($category->name);
        ?>


        <x-panel-box :args="$args">

            @include('blog::category._form',['type'=>'edit'])

        </x-panel-box>

    </div>

@endsection
