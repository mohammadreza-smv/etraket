@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
              ['title'=>'مدیریت کمیسیون ها','url'=>url('admin/affiliate/commissions')]
        ]])


        <?php
             $args['title']='مدیریت کمیسیون ها';
             $args['route']='admin/affiliate/commissions';
             $args['trashCount']=$trash_commission_count;
             $args['routeParam']='کمیسیون';
        ?>

        @includeIf('affiliate::commissions._search_form')

        <x-panel-box :args="$args">

            <?php

            \App\Lib\GridView::showTable([
                'dataProvider'=>$commissions,
                'columns'=>[
                    ['label'=>'دسته','attr'=>function($value){
                         if($value->category!==null){
                             return e($value->category->name);
                         }
                    }],
                    ['label'=>'برند','attr'=>function($value){
                        if($value->brand!==null){
                            return e($value->brand->brand_name);
                        }
                    }],
                    ['label'=>'درصد کمیسیون','attr'=>function($value){
                        return '٪'.e(replace_number($value->percentage));
                    }]
                ],
                'route_param'=>'affiliate/commissions',
                'tableLabel'=>'کمیسیون'
            ]);
            ?>

            {{ $commissions->links() }}
        </x-panel-box>
    </div>

@endsection
