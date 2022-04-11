@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'تنظیمات اتصال به درگاه بانک ملت','url'=>url('admin/setting/gateway/mellat')],
        ]])

        <?php
        $args=[];
        $args['title']='تنظیمات اتصال به درگاه بانک ملت';
        ?>

        <x-panel-box :args="$args">

            <?php
            $option=['url' => 'admin/setting/gateway/mellat'];
            $form=new \App\Lib\FormBuilder($errors,$option);
            ?>

            <?php $form->textInput('TerminalId','ترمینال ای دی ',['validate'=>'required'],$data['TerminalId']); ?>

            <?php $form->textInput('Username','نام کاربری ',['validate'=>'required'],$data['Username']); ?>

            <?php $form->textInput('Password','کلمه عبور ',['validate'=>'required'],$data['Password']); ?>


            <?php $form->btn('ثبت اطلاعات', 'create'); ?>

            <?php $form->close(); ?>

        </x-panel-box>

    </div>

@endsection
