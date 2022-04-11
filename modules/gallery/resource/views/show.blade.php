@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت محصولات','url'=>url('admin/products')],
             ['title'=>'گالری تصاویر','url'=>url('admin/products/gallery/'.$product->id)]
        ]])


        <?php
            $args=[];
            $args['title']='  گالری تصاویر - '.$product->title;
        ?>

        <x-panel-box :args="$args">

            <upload-box
                product_id="{{ $product->id }}"
                :product_gallery="{{ $product_gallery }}"
                url_param="admin"
            ></upload-box>

        </x-panel-box>

    </div>

@endsection


