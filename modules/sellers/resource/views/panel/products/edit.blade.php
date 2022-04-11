@extends('sellers::layouts.panel')

@section('content')

    <div>


        @include('sellers::panel.breadcrumb',['data'=>[
              ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
              ['title'=>'ویرایش محصول','url'=>url('sellers/panel/products/'.$product->id.'/edit')],
        ]])

        <?php $args=['title'=>'ویرایش محصول '.$product->title] ?>


        <x-seller-panel-box :args="$args">
            @includeIf('products::_form',[
                 'type'=>'edit',
                 'filters'=>['status'],
                 'url'=>'sellers/panel/products'
            ])
        </x-seller-panel-box>

    </div>

@endsection
