@extends('front-theme::layouts.user-panel')

@section('panel-content')

    <?php $args=['title'=>'ارسال پیام جدید']; ?>



    <x-user-panel-box :args="$args">

        <div class="message_form">
            <?php
            $option=['url' => 'user/profile/messages','files'=>true];
            $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);
            ?>

            <?php $form->textInput('title','عنوان',['validate'=>'required','class'=>'total-width']); ?>

            <?php $form->textarea('content','محتوای پیام',['validate'=>'required','class'=>'total-width']); ?>

            <?php $form->fileInput('pic','انتخاب فایل',['class'=>'small']); ?>

            <?php $form->btn('ارسال پیام', 'create'); ?>

            <?php $form->close(); ?>
        </div>

        <response-dialog></response-dialog>

    </x-user-panel-box>

@endsection
