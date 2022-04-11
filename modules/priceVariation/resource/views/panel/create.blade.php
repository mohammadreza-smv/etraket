@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت تنوع های قیمت','url'=>url('admin/product/price_variation?product_id='.$product->id)],
             ['title'=>'افزودن تنوع قیمت','url'=>url('admin/product/price_variation/create?product_id='.$product->id)]
        ]])


        <?php
            $args=[];
            $args['title']='افزون تنوع قیمت جدید برای '.e($product->title);
        ?>

        <x-panel-box :args="$args">

            @include('priceVariation::panel._form',['type'=>'create'])

        </x-panel-box>


    </div>

@endsection

