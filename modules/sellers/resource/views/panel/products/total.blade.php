@extends('sellers::layouts.panel')

@section('content')

    <div>

        @include('sellers::panel.breadcrumb',['data'=>[
           ['title'=>'محصولات فروشگاه','url'=>url('sellers/panel/products/total/show')],
        ]])

        @includeIf('sellers::panel.products._search_form',['url'=>'sellers/panel/products/total/show'])

        <?php $args=['title'=>'محصولات فروشگاه'] ?>

        <x-seller-panel-box :args="$args">

            <?php
                $status=\Modules\products\Models\Product::ProductStatus();
                define('status',$status);
            ?>
            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$products,
                'columns'=>[
                    ['label'=>'تصویر محصول','attr'=>function($model){
                        $src=url('files/thumbnails/'.$model->image_url);
                        return '<img src="'.$src.'" class="product_pic" style="margin:20px;width:100px">';
                    },'html'=>true],
                    ['label'=>'عنوان','attr'=>'title'],
                    ['label'=>'حداقل قیمت فروش','attr'=>function($model){
                        return get_price($model->price);
                    }],
                    ['label'=>'وضعیت محصول','attr'=>function($model){
                        if(array_key_exists($model->status,status)){
                            $class=($model->status==1)  ? "alert-success" : 'alert-warning';
                            return '<span class="'.$class.'" style="font-size:13px;padding:5px 7px;width:80px;display: block;">'.status[$model->status] .'</span>';
                        }
                    },'html'=>true]
                ],
                'actions'=>[
                     function($model){
                         $url=url('sellers/panel/product/price_variation?product_id='.$model->id);
                         return '<a href="'.$url.'" class="router-link"><v-btn color="error">من هم میفروشم</v-btn></a>';
                      }
                ],
                'route_param'=>'sellers/panel/products',
                'tableLabel'=>'محصول',
                'viewComponent'=>'seller-product-list',
            ],true,true);
            ?>
            {{ $products->links() }}

        </x-seller-panel-box>

    </div>

@endsection
