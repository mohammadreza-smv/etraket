@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت نقد و بررسی ها','url'=>url('admin/product/review?product_id='.$product->id)],
            ['title'=>'افزودن توضیحات اولیه','url'=>url('admin/product/review/primary?product_id='.$product->id)]
        ]])

        <?php
            $args=[];
            $args['title']='افزودن توضیحات اولیه نقد و بررسی جدید برای '.e($product->title);
        ?>

        <x-panel-box :args="$args">

            <?php
            $option=['url' => 'admin/product/review/primary','query_string'=>'?product_id='.$product->id];
            $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);
            ?>
            <?php $form->editor('tozihat',['class'=>'form-control ckeditor'],$tozihat); ?>

            <?php $form->btn('ثبت', 'create'); ?>

            <?php $form->close(); ?>

        </x-panel-box>


    </div>

@endsection
