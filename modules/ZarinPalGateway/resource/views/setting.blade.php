@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'تنظیمات اتصال به درگاه زرین پال','url'=>url('admin/setting/gateway/zarinpal')],
        ]])

        <?php
            $args=[];
            $args['title']='تنظیمات اتصال به درگاه زرین پال';
        ?>

        <x-panel-box :args="$args">

            <?php
            $option=['url' => 'admin/setting/gateway/zarinpal'];
            $form=new \App\Lib\FormBuilder($errors,$option);
            ?>

            <?php $form->textInput('MerchantID','MerchantID',['validate'=>'required'],$data['MerchantID']); ?>

            <?php $form->btn('ثبت ', 'create'); ?>

            <?php $form->close(); ?>

        </x-panel-box>

    </div>

@endsection
