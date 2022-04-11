@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','url'=>url('admin/products')],
            ['title'=>'ثبت مشخصات فنی محصول','url'=>url('admin/products/'.$product->id.'/items')]
        ]])

        <?php
            $args=[];
            $args['title']=' افزودن مشخصات فنی - '.e($product->title);
        ?>


        <x-panel-box :args="$args">
            <add-product-items
                :product_items="{{ json_encode($product_items) }}"
                product_id="{{ $product->id }}"
                route_param="admin"
            >
                <template v-slot:after_input="slotProps">
                    @include('CompleteView',[
                        'path'=>'add-item-input',
                        'name'=>'add_value_input_tag',
                        'component'=>'yes'
                    ])
                </template>
            </add-product-items>
        </x-panel-box>

    </div>
@endsection
