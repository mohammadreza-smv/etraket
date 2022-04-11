@extends('backend-theme::layout')

@section('content')


    <div>

        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت دسته بندی ها','url'=>url('admin/category')],
             ['title'=>'مدیریت ویژگی ها','url'=>url('admin/category/'.$category->id.'/items')]
        ]])

        <?php
            $args=[];
            $args['title']='مدیریت ویژگی های دسته '.e($category->name);
        ?>

        <x-panel-box :args="$args">

            <cat-items :items="{{ json_encode($items) }}" cat_id="{{ $category->id }}"></cat-items>

        </x-panel-box>

    </div>

@endsection


