@extends('sellers::layouts.panel')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
             ['title'=>'گالری تصاویر','url'=>url('sellers/panel/products/gallery/'.$product->id)]
        ]])

        <?php
            $args=['title'=>'  گالری تصاویر - '.$product->title];
        ?>

        <x-seller-panel-box :args="$args">

            <upload-box
                product_id="{{ $product->id }}"
                :product_gallery="{{ $product_gallery }}"
                url_param="sellers/panel"
            >

            </upload-box>

        </x-seller-panel-box>

    </div>

@endsection
