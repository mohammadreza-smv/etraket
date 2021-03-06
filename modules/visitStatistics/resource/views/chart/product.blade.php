@extends('backend-theme::layout')

@section('content')

    <div>

        @if($product)
            @include('backend-theme::breadcrumb',['data'=>[
                 ['title'=>'آمار بازدید محصول','url'=>url('admin/product/visit/'.$product->id)]
            ]])

            <?php
                $args=[];
                $args['title']='آمار بازید محصول - '.$product->title;
            ?>

            <x-panel-box :args="$args">
                <product-visit product_id="{{ $product->id }}"></product-visit>
            </x-panel-box>
        @endif

    </div>

@endsection
