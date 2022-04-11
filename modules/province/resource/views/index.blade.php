@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
              ['title'=>'مدیریت استان ها','url'=>url('admin/province')]
        ]])

        @include('province::_search_form')

        <?php
            $args=[];
            $args['title']='مدیریت استان ها';
            $args['route']='admin/province';
            $args['trashCount']=$trash_province_count;
            $args['routeParam']='استان';
        ?>

        <x-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$province,
                'columns'=>[
                    ['label'=>'نام استان','attr'=>'name']
                ],
                'route_param'=>'province',
                'tableLabel'=>'استان'
            ]);
            ?>

            {{ $province->links() }}

        </x-panel-box>

    </div>

@endsection
