@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت دسته ها','url'=>url('admin/blog/categories')]
        ]])

        @include('blog::category._search_form')

        <?php
            $args=[];
            $args['title']='مدیریت دسته ها';
            $args['route']='admin/blog/categories';
            $args['trashCount']=$trash_cat_count;
            $args['routeParam']='دسته';
        ?>

        <x-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$category,
                'tableLabel'=>'دسته',
                'route_param'=>'blog/categories',
                'columns'=>[
                    ['label'=>'شناسه دسته','attr'=>function($model){
                        return e(replace_number($model->id));
                    }],
                    ['label'=>'نام دسته','attr'=>'name'],
                    ['label'=>'دسته والد','attr'=>function($model){
                        return e($model->parent->name);
                    }]
                ]
            ]);
            ?>

            {{ $category->links() }}

        </x-panel-box>

    </div>

@endsection

