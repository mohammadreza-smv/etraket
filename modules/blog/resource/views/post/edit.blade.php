@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت پست ها','url'=>url('admin/blog/posts')],
            ['title'=>'ویرایش پست','url'=>url('admin/blog/posts/'.$post->id.'/edit')]
        ]])

        <div class="panel">

            <div class="header">
                ویرایش پست - {{ $post->title }}
            </div>

            @include('blog::post._form',['type'=>'edit'])

        </div>
    </div>

@endsection

