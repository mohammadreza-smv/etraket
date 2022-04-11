@extends('backend-theme::layout')

@section('content')

    <div>

        <?php
             $array['users']= 'مدیریت کاربران';
             $array['sellers']= 'مدیریت فروشندگان';
        ?>

        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>$array[$url_param],'url'=>url('admin/'.$url_param)],
             ['title'=>'مدیریت پیام ها','url'=>url('admin/'.$url_param.'/'.$user->id.'/messages')],
             ['title'=>'ارسال پیام جدید','url'=>url('admin/'.$url_param.'/'.$user->id.'/messages/create')],
        ]])

        <?php
            $args=[];
            $attr=$types[$type]['attr'];
            $name=$user->$attr!='' ? $user->$attr : $user->mobile;
        ?>

        <x-panel-box :args="$args">

            <x-slot name="header">

                ارسال پیام به
                {{ $name }}

            </x-slot>

            <?php
                $option=['url' =>'admin/'.$url_param.'/'.$user->id.'/messages'];
                $form=new \App\Lib\FormBuilder(null,$option, 'create',[]);
            ?>

            <?php $form->textInput('title','عنوان',['validate'=>'required','class'=>'total-width']); ?>

            <?php $form->textarea('content','محتوای پیام',['validate'=>'required','class'=>'total-width']); ?>

            <?php $form->fileInput('pic','انتخاب فایل',['class'=>'small']); ?>

            <?php $form->btn('ارسال پیام','edit'); ?>

            {!! Form::close() !!}

        </x-panel-box>

    </div>

@endsection
