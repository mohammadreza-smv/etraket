@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت محصولات','url'=>url('admin/products')],
             ['title'=>'ثبت فیلتر های محصول','url'=>url('admin/products/'.$product->id.'/filters')]
        ]])

        <?php
            $args=[];
            $args['title']='افزودن فیلتر ها - '.e($product->title);
        ?>

        <x-panel-box :args="$args">
            <add-product-filters
                :product_filters="{{ json_encode($product_filters) }}"
                product_id="{{ $product->id }}"
            >

            </add-product-filters>
        </x-panel-box>

    </div>

@endsection
