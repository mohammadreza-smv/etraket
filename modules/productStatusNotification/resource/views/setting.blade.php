@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
              ['title'=>'تنظیمات اطلاع رسانی موجود شدن محصولات','url'=>url('admin/notification/product/setting')],
        ]])

        <?php
            $args=['title'=>'تنظیمات اطلاع رسانی موجود شدن محصولات'];
        ?>

        <x-panel-box :args="$args">

            <?php
                $option=['url' => 'admin/notification/product/setting'];
                $form=new \App\Lib\FormBuilder(null,$option);
            ?>

            <?php

            $form->select(
                $channelList,
                'product-notification-channel',
                'انتخاب وب سرویس',
                ['dense'=>true],
                $data['product-notification-channel']
            );

            ?>

            <?php $form->textInput('product-notification-api-key','ای پی ای',['validate'=>'required'],$data['product-notification-api-key']); ?>

            <?php $form->textInput('product-notification-line-number','شماره خط',[],$data['product-notification-line-number']); ?>

            <?php $form->btn('ثبت اطلاعات', 'create'); ?>

            <?php $form->close(); ?>

        </x-panel-box>

    </div>

@endsection
