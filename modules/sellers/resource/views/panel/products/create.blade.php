@extends('sellers::layouts.panel')

@section('content')

    <div>


        @include('sellers::panel.breadcrumb',['data'=>[
              ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
              ['title'=>'افزودن محصول جدید','url'=>url('sellers/panel/products/create')],
        ]])

        <?php $args=['title'=>'افزودن محصول جدید'] ?>


        <x-seller-panel-box :args="$args">
            @includeIf('products::_form',[
                 'type'=>'create',
                 'filters'=>['status'],
                 'url'=>'sellers/panel/products'
            ])
        </x-seller-panel-box>

    </div>

@endsection
