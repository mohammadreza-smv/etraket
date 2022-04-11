@extends('sellers::layouts.panel')

@section('content')

    <div>


        @include('sellers::panel.breadcrumb',['data'=>[
              ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
              ['title'=>'مدیریت تنوع های قیمت','url'=>url('sellers/panel/product/price_variation?product_id='.$product->id)],
        ]])


        <?php
              $title='مدیریت تنوع های قیمت '.e( $product->title);
              $args=[];
              $args['title']=$title;
              $args['route']='sellers/panel/product/price_variation';
              $args['trashCount']=$trash_price_variation_count;
              $args['routeParam']='تنوع قیمت';
              $args['queryString']=['param'=>'product_id','value'=>$product->id];

             $deleteList=isset($_GET['trashed']) ? true : false;
        ?>

        <x-seller-panel-box :args="$args">

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$price_variation,
                'columns'=>[
                    ['label'=>'قیمت محصول','attr'=>function($model){
                        $price=replace_number(number_format($model->price1)). 'تومان' ;
                        return '<div class="alert alert-success" style="padding:10px">'.Htmlspecialchars($price,ENT_QUOTES).'</div>';
                    },'html'=>true],

                    ['label'=>'قیمت محصول برای فروش','attr'=>function($model){
                        $price=replace_number(number_format($model->price2)). 'تومان' ;
                        return '<div class="alert alert-warning" style="padding:10px">'.Htmlspecialchars($price,ENT_QUOTES).'</div>';
                    },'html'=>true,'style'=>'min-width:160px'],

                    ['label'=>'تعداد موجودی محصول','attr'=>'product_number']
                ],

                'tableLabel'=>'تنوع قیمت',
                'route_param'=>'product/price_variation',
                'route_query_string'=>'?product_id='.$product->id,
                'actionRouteParam'=>'sellers/panel'
            ],false,$deleteList);
            ?>

            {{ $price_variation->links() }}
        </x-seller-panel-box>

    </div>

@endsection
