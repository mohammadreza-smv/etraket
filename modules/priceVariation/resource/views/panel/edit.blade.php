@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت تنوع های قیمت','url'=>url('admin/product/price_variation?product_id='.$product->id)],
            ['title'=>'ویرایش تنوع قیمت','url'=>url('admin/product/price_variation/'.$price_variation->id.'/edit?product_id='.$product->id)]
        ]])

        <?php
            $args=[];
            $args['title']='ویرایش تنوع قیمت - '.e($product->title);
        ?>

        <x-panel-box :args="$args">

            @include('priceVariation::panel._form',['type'=>'edit'])

        </x-panel-box>

    </div>

@endsection


