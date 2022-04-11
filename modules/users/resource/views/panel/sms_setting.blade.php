@extends('backend-theme::layout')

@section('content')

     <div>

         @include('backend-theme::breadcrumb',['data'=>[
               ['title'=>'تنظیمات ارسال پیامک به کاربران','url'=>url('admin/user/sms/channel')],
         ]])

         <?php
         $args=[];
         $args['title']='تنظیمات ارسال پیامک به کاربران';
         ?>

         <x-panel-box :args="$args">

             <?php
                 $option=['url' => 'admin/user/sms/channel'];
                 $form=new \App\Lib\FormBuilder($errors,$option);
             ?>

             <?php

             $form->select(
                 $channelList,
                 'users-channel',
                 'انتخاب وب سرویس',
                 [],
                 $data['users-channel']
             );

             ?>

             <?php $form->textInput('users-api-key','ای پی ای',['validate'=>'required'],$data['users-api-key']); ?>

             <?php $form->textInput('users-line_number','شماره خط',[],$data['users-line_number']); ?>


             <?php $form->textInput('users-active_template','قالب ارسال کد فعال سازی ',[],$data['users-active_template']); ?>

             <?php $form->btn('ثبت اطلاعات', 'create'); ?>

             <?php $form->close(); ?>

         </x-panel-box>

     </div>

@endsection
