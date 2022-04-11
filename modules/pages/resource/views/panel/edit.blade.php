@extends('backend-theme::layout')

@section('content')

    <div>


        @include('backend-theme::breadcrumb',['data'=>[
           ['title'=>'مدیریت صفحات اضافی','url'=>url('admin/pages')],
           ['title'=>'ویرایش صفحه','url'=>url('admin/pages/'.$page->id.'/edit')]
        ]])


        <?php
            $args=[];
            $args['title']=' ویرایش صفحه -'.e($page->title);
        ?>

        <x-panel-box :args="$args">

            @include('pages::panel._form',['type'=>'edit'])

        </x-panel-box>

    </div>

@endsection


