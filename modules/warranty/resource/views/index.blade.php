@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت گارانتی ها','url'=>url('admin/warranties')]]])

        @include('warranty::_search_form')

        <?php
            $args=[];
            $args['title']='مدیریت گارانتی ها';
            $args['route']='admin/warranties';
            $args['trashCount']=$trash_warranty_count;
            $args['routeParam']='گارانتی';
        ?>

        <x-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$warranty,
                'columns'=>[
                    ['label'=>'نام گارانتی','attr'=>'name']
                ],
                'route_param'=>'warranties',
                'tableLabel'=>'گارانتی'
            ]);
            ?>

            {{ $warranty->links() }}

        </x-panel-box>

    </div>

@endsection
