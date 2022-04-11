@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت نقد و بررسی ها','url'=>url('admin/product/review?product_id='.$product->id)],
            ['title'=>'افزودن نقد و بررسی جدید','url'=>url('admin/product/review/create?product_id='.$product->id)]
        ]])

        <?php
            $args=[];
            $args['title']='افزودن نقد و بررسی جدید برای '.e($product->title);
        ?>

        <x-panel-box :args="$args">

            @include('review::panel._form',['type'=>'create'])

        </x-panel-box>

    </div>

@endsection

