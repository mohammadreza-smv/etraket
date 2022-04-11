@extends('backend-theme::layout')

@section('content')

     <div>

         @include('backend-theme::breadcrumb',['data'=>[
               ['title'=>'تنظیمات ارسال پیامک به فروشندگان','url'=>url('admin/sellers/sms/channel')],
         ]])

         <?php
         $args=[];
         $args['title']='تنظیمات ارسال پیامک به فروشندگان';
         ?>

         <x-panel-box :args="$args">

             <?php
                 $option=['url' => 'admin/sellers/sms/channel'];
                 $form=new \App\Lib\FormBuilder($errors,$option);
             ?>

             <?php

             $form->select(
                 $channelList,
                 'sellers-channel',
                 'انتخاب وب سرویس',
                 ['dense'=>'true'],
                 $data['sellers-channel']
             );

             ?>

             <?php $form->textInput('sellers-api-key','ای پی ای',['validate'=>'required'],$data['sellers-api-key']); ?>

             <?php $form->textInput('sellers-line_number','شماره خط',[],$data['sellers-line_number']); ?>


             <?php $form->textInput('sellers-active_template','قالب ارسال کد فعال سازی ',[],$data['sellers-active_template']); ?>

             <?php $form->btn('ثبت اطلاعات', 'create'); ?>

             <?php $form->close(); ?>

         </x-panel-box>

     </div>

@endsection
