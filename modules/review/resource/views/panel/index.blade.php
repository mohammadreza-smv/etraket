@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
           ['title'=>'مدیریت نقد و بررسی ها','url'=>url('admin/product/review?product_id='.$product->id)]
          ]])

        <?php

             $title='مدیریت نقد و بررسی ها '.e($product->title);
             $args=[];
             $args['title']=$title;
             $args['route']='admin/product/review';
             $args['trashCount']=$trash_review_count;
             $args['routeParam']='نقد و بررسی';
             $args['queryString']=['param'=>'product_id','value'=>$product->id]

        ?>


        <x-panel-box :args="$args">

            <v-btn style="margin-bottom: 20px" color="primary">
                <a  class="router-link" style="color: white;text-decoration: none" href="{{ url('admin/product/review/primary?product_id='.$product->id) }}">افزودن توضیحات اولیه</a>
            </v-btn>

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$review,
                'columns'=>[
                    ['label'=>'عنوان نقد و بررسی','attr'=>'title']
                ],
                'tableLabel'=>'نقد و بررسی',
                'route_param'=>'product/review',
                'route_query_string'=>'?product_id='.$product->id
            ]);
            ?>

            {{ $review->links() }}

        </x-panel-box>


    </div>

@endsection
