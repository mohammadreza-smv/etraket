@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت دسته بندی ها','url'=>url('admin/category')],
            ['title'=>'مدیریت معیار تعیین قیمت','url'=>url('admin/category/'.$category->id.'/price_variation')]
        ]])


        <?php
             $args=[];
             $args['title']='مدیریت معیار تعیین قیمت دسته '.e($category->name);
        ?>

        <x-panel-box :args="$args">

            <add-product-variation
                :items="{{ json_encode($items) }}"
                :price_variation_param="{{ json_encode($priceVariationParam) }}"
                :category="{{ json_encode($category) }}"
            ></add-product-variation>

        </x-panel-box>

    </div>
@endsection



