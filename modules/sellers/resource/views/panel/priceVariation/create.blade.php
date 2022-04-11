@extends('sellers::layouts.panel')

@section('content')

    <div>


        @include('sellers::panel.breadcrumb',['data'=>[
              ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
              ['title'=>'مدیریت تنوع های قیمت','url'=>url('sellers/panel/product/price_variation?product_id='.$product->id)],
        ]])


        <?php
            $args=[];
            $args['title']='افزون تنوع قیمت جدید برای '.e($product->title);
        ?>


        <x-seller-panel-box :args="$args">
            @includeIf('priceVariation::panel._form',['type'=>'create','url'=>'sellers/panel/product/price_variation'])
        </x-seller-panel-box>

    </div>

@endsection
