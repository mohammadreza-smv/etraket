@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','url'=>url('admin/products')],
            ['title'=>'ویرایش محصول','url'=>url('admin/products/'.$product->id.'/edit')]
        ]])

        <?php
           $status=\Modules\products\Models\Product::ProductStatus();
           $jdf=new App\Lib\Jdf();
        ?>
        <div class="panel">

            <div class="header">
                ویرایش محصول - {{ $product->title }}
            </div>

            @include('products::_form',['type'=>'edit'])

        </div>
    </div>

@endsection

