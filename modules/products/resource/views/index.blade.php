@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',[
             'data'=>[['title'=>'مدیریت محصولات','url'=>url('admin/products')]]
        ])

        @include('products::_search_form')

        <?php
            $args['title']='مدیریت محصولات';
            $args['route']='admin/products';
            $args['trashCount']=$trash_product_count;
            $args['routeParam']='محصول';
            $args['progress-param']='admin/products';
        ?>

        <x-panel-box :args="$args">

            <?php  $status=\Modules\products\Models\Product::ProductStatus(); define('status',$status); ?>

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$product,
                'columns'=>[
                    ['label'=>'تصویر محصول','attr'=>function($model){
                        $src=url('files/thumbnails/'.$model->image_url);
                        return '<img src="'.$src.'" class="product_pic" style="margin:20px;">';
                    },'html'=>true],
                    ['label'=>'عنوان','attr'=>'title'],
                    ['label'=>'وضعیت محصول','attr'=>function($model){
                        if(array_key_exists($model->status,status)){
                            $class=($model->status==1)  ? "alert-success" : 'alert-warning';
                            return '<span class="'.$class.'" style="font-size:13px;padding:5px 7px;width:80px;display: block;">'.status[$model->status] .'</span>';
                        }
                    },'html'=>true]
                ],
                'route_param'=>'products',
                'tableLabel'=>'محصول'
            ]);
            ?>

            {{ $product->links() }}

        </x-panel-box>

    </div>

@endsection
