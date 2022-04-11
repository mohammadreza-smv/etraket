@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'تنظیمات اتصال به درگاه پرداخت بانک پارسیان','url'=>url('admin/setting/gateway/ipgsw')],
       ]])

        <?php
            $args=[];
            $args['title']='تنظیمات اتصال به درگاه پرداخت بانک پارسیان';
        ?>

        <x-panel-box :args="$args">

            <?php
                $option=['url' => 'admin/setting/gateway/ipgsw'];
                $form=new \App\Lib\FormBuilder($errors,$option);
            ?>

            <?php $form->textInput('PIN','پین ',[],$data['PIN']); ?>

            <?php $form->btn('ثبت', 'create'); ?>

            <?php $form->close(); ?>

        </x-panel-box>
    </div>

@endsection
