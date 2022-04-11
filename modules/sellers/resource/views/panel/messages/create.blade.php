@extends('sellers::layouts.panel')

@section('content')

    <?php $args=['title'=>'ارسال پیام جدید']; ?>

    <div>

        @include('sellers::panel.breadcrumb',['data'=>[
          ['title'=>'مدیریت پیام ها','url'=>url('sellers/panel/messages')],
        ]])

        <x-seller-panel-box :args="$args">

            <div class="message_form">
                <?php
                $option=['url' => 'sellers/panel/message'];
                $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);
                ?>

                <?php $form->textInput('title','عنوان',['validate'=>'required','class'=>'total-width']); ?>

                <?php $form->textarea('content','محتوای پیام',['validate'=>'required','class'=>'total-width']); ?>

                <?php $form->fileInput('pic','انتخاب فایل',['class'=>'small']); ?>

                <?php $form->btn('ارسال پیام', 'create'); ?>

                <?php $form->close(); ?>
            </div>

        </x-seller-panel-box>

    </div>

@endsection
