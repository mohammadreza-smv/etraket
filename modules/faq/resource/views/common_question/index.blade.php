@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت پرسش های متداول','url'=>url('admin/common-question')]]])

        @include('faq::common_question._search_form')

        <?php
            $args=[];
            $args['title']='مدیریت پرسش های متداول';
            $args['route']='admin/common-question';
            $args['trashCount']=$trash_common_question_count;
            $args['routeParam']='پرسش متداول';
        ?>

        <x-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$CommonQuestion,
                'columns'=>[
                    ['label'=>'عنوان پرسش','attr'=>'title'],
                    ['label'=>'دسته','attr'=>function($model){
                        return $model->cat->title;
                    }]
                ],
                'route_param'=>'common-question',
                'tableLabel'=>'پرسش'
            ]);
            ?>

            {{ $CommonQuestion->links() }}

        </x-panel-box>


    </div>

@endsection
