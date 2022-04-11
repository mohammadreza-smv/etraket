@extends('sellers::layouts.panel')

@section('content')

    <div>

        @include('sellers::panel.breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
            ['title'=>'ثبت مشخصات فنی محصول','url'=>url('sellers/panel/products/'.$product->id.'/items')]
        ]])

        <?php
        $args=[];
        $args['title']=' افزودن مشخصات فنی - '.e($product->title);
        ?>


        <x-seller-panel-box :args="$args">
            <add-product-items
                :product_items="{{ json_encode($product_items) }}"
                product_id="{{ $product->id }}"
                route_param="sellers/panel"
            >
                <template v-slot:after_input="slotProps">
                    @include('CompleteView',[
                        'path'=>'add-item-input',
                        'name'=>'add_value_input_tag',
                        'component'=>'yes'
                    ])
                </template>
            </add-product-items>
        </x-seller-panel-box>

    </div>
@endsection
