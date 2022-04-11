@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',[
             'data'=>[['title'=>'لیست محصولات در انتظار موجود شدن','url'=>url('admin/notification/products')]]
        ])

        @include('productStatusNotification::_search_form')

        <?php
            $args=[];
            $args['title']='لیست محصولات در انتظار موجود شدن';
        ?>

        <x-panel-box :args="$args">


            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$products,
                'columns'=>[
                    ['label'=>'تصویر محصول','attr'=>function($model){
                        $src=url('files/thumbnails/'.$model->image_url);
                        return '<a href="'.shop_product_url($model).'" target="_blank"><img src="'.$src.'"
                        class="product_pic" style="margin:20px;"></a>';
                    },'html'=>true],
                    ['label'=>'عنوان','attr'=>function($model){
                        return $model->title;
                    }],
                    ['label'=>'تعداد درخواست','attr'=>function($model){
                           return replace_number($model->request_count);
                    }],
                ],
                'route_param'=>'products',
                'tableLabel'=>'محصول'
            ],true,true);
            ?>

            {{ $products->links() }}

        </x-panel-box>

    </div>

@endsection
