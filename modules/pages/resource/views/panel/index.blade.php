@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت صفحات اضافی','url'=>url('admin/pages')]]])

        @include('pages::panel._search_form')

        <?php
            $args=[];
            $args['title']='مدیریت صفحات اضافی';
            $args['route']='admin/pages';
            $args['trashCount']=$trash_page_count;
            $args['routeParam']='صفحه';
        ?>

        <x-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$pages,
                'columns'=>[
                    ['label'=>'عنوان صفحه','attr'=>'title'],
                ],
                'tableLabel'=>'صفحه اضافی',
                'route_param'=>'pages',
                'actions'=>[
                    function($model){
                        $url=url('page/'.$model->url);
                        return '<a href="'.$url.'"  target="_blank" style="color:#000">
                                    <v-icon>mdi-eye</v-icon>
                                 </a> ';
                    }
                ]
            ]);
            ?>

            {{ $pages->links() }}

        </x-panel-box>

    </div>

@endsection
