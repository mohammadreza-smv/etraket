@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت پرسش ها','url'=>url('admin/questions')]]])

        <?php
            $args=[];
            $args['title']='  پرسش ها و پاسخ های کاربران';
            $args['route']='admin/questions';
            $args['trashCount']=$trash_question_count;
            $args['routeParam']='پرسش';
            $args['remove_new_record']=true;
        ?>

        <x-panel-box :args="$args">

            <panel-question-list
                :questions="{{ json_encode($questions) }}"
                :removed="true"
            ></panel-question-list>

            {{ $questions->links() }}

        </x-panel-box>

    </div>

@endsection
