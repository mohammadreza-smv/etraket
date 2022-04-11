@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت نظرات','url'=>url('admin/comments')]]])

        <?php
              $args=[];
              $args['title']='نظرات کاربران';
              $args['route']='admin/comments';
              $args['trashCount']=$trash_comment_count;
              $args['routeParam']='نظر';
              $args['remove_new_record']=true;
        ?>

        <x-panel-box :args="$args">

             <panel-comment-list
                 :comments="{{ json_encode($comments) }}"
                 :removed="true"
             ></panel-comment-list>

            {{ $comments->links() }}

        </x-panel-box>
    </div>

@endsection
