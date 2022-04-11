@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
              ['title'=>'پرسش های متداول','url'=>url('admin/common-question')],
              ['title'=>'مدیریت دسته ها','url'=>url('admin/category-common-question')]
         ]])

        @include('faq::category_common_question._search_form')

        <?php
            $args=[];
            $args['title']='مدیریت دسته ها';
            $args['route']='admin/category-common-question';
            $args['trashCount']=$trash_common_question_cat_count;
            $args['routeParam']='دسته';
        ?>

        <x-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$CategoryCommonQuestion,
                'columns'=>[
                    ['label'=>'نام دسته','attr'=>'title']
                ],
                'route_param'=>'category-common-question',
                'tableLabel'=>'دسته'
            ]);
            ?>
            {{ $CategoryCommonQuestion->links() }}

        </x-panel-box>

    </div>


@endsection
