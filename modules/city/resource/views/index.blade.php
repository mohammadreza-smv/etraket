@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت شهر ها','url'=>url('admin/city')]]])

        @include('city::_search_form')

        <?php
            $args=[];
            $args['title']='مدیریت شهر ها';
            $args['route']='admin/city';
            $args['trashCount']=$trash_city_count;
            $args['routeParam']='شهر';
        ?>

        <x-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$city,
                'columns'=>[
                    ['label'=>'نام شهر','attr'=>'name'],
                    ['label'=>'استان','attr'=>function($model){
                        return $model->getProvince->name;
                    }]
                ],
                'route_param'=>'city',
                'tableLabel'=>'شهر'
            ]);
            ?>

            {{ $city->links() }}

        </x-panel-box>

    </div>

@endsection
