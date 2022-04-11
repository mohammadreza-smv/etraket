@extends('sellers::layouts.panel')

@section('content')


    <div>

        @include('sellers::panel.breadcrumb',['data'=>[
              ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
        ]])

        <?php $args=['title'=>'مدیریت محصولات'] ?>


        @includeIf('sellers::panel.products._search_form')

        <x-seller-panel-box :args="$args">

            <?php
                 $status=\Modules\products\Models\Product::ProductStatus();
                 define('status',$status);
                 $seller_id=\Auth::guard('seller')->user()->id
           ?>

            <?php
               \App\Lib\GridView::showTable([
                'dataProvider'=>$product,
                'columns'=>[
                    ['label'=>'تصویر محصول','attr'=>function($model){
                        $src=url('files/thumbnails/'.$model->image_url);
                        return '<img src="'.$src.'" class="product_pic" style="margin:20px;width:100px">';
                    },'html'=>true],
                    ['label'=>'عنوان','attr'=>'title'],
                    ['label'=>'وضعیت محصول','attr'=>function($model){
                        if(array_key_exists($model->status,status)){
                            $class=($model->status==1)  ? "alert-success" : 'alert-warning';
                            return '<span class="'.$class.'" style="font-size:13px;padding:5px 7px;width:80px;display: block;">'.status[$model->status] .'</span>';
                        }
                    },'html'=>true]
                ],
                'actions'=>[
                    function($model){
                        if($model->status<-1){
                            $url=url('sellers/panel/products/'.$model->id);
                            return '<delete-link row-id="'.$model->id.'" sendTrash="yes" label="محصول" url="'.$url.'"></delete-link>';
                        }
                    },
                    function($model){
                        if($model->seller_id===get_seller_id()){
                            $url=url('sellers/panel/products/'.$model->id.'/edit');
                            return '<a class="router-link" href="'.$url.'"><v-icon color="primary">mdi-circle-edit-outline</v-icon></a>';
                        }
                    }
                ],
                'route_param'=>'sellers/panel/products',
                'tableLabel'=>'محصول',
                'viewComponent'=>'seller-product-list seller_id='.$seller_id.'',
                'props'=>['seller_id']
            ],true,true);
            ?>

            {{ $product->links() }}

        </x-seller-panel-box>
    </div>

@endsection
