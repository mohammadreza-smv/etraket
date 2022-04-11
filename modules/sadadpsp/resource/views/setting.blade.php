@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
         ['title'=>'تنظیمات اتصال به درگاه سداد','url'=>url('admin/setting/gateway/sadadpsp')],
        ]])

        <?php
        $args=[];
        $args['title']='تنظیمات اتصال به درگاه سداد';
        ?>

        <x-panel-box :args="$args">

            <?php
            $option=['url' => 'admin/setting/gateway/zarinpal'];
            $form=new \App\Lib\FormBuilder(null,$option);
            ?>

            <?php $form->textInput('sadad_merchantId','شماره پذيرنده',['validate'=>'required'],$data['sadad_merchantId']); ?>

            <?php $form->textInput('sadad_terminalId','شماره ترمینال',['validate'=>'required'],$data['sadad_terminalId']); ?>

            <?php $form->textInput('sadad_terminalKey','کلید تراکنش',['validate'=>'required'],$data['sadad_terminalKey']); ?>

            <?php $form->btn('ثبت ', 'create'); ?>

            <?php $form->close(); ?>

        </x-panel-box>

    </div>

@endsection
