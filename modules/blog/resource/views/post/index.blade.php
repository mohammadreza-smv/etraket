@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',[
             'data'=>[['title'=>'مدیریت پست ها','url'=>url('admin/blog/posts')]]
        ])

        @include('blog::post._search_form')

        <?php
            $args=[];
            $args['title']='مدیریت پست ها';
            $args['route']='admin/blog/posts';
            $args['trashCount']=$trash_post_count;
            $args['routeParam']='پست';
        ?>

        <x-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$posts,
                'columns'=>[
                    ['label'=>'تصویر پست','attr'=>function($model){
                        $src=url('files/thumbnails/'.$model->pic);
                        return '<img src="'.$src.'" class="product_pic" style="margin:20px;">';
                    },'html'=>true],
                    ['label'=>'عنوان','attr'=>'title'],
                    ['label'=>'دسته','attr'=>function($model){
                        return e($model->category->name);
                    }]

                ],
                'route_param'=>'blog/posts',
                'tableLabel'=>'پست'
            ]);
            ?>

            {{ $posts->links() }}

        </x-panel-box>

    </div>

@endsection
