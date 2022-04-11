@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'تنظیمات دامنه وبلاگ','url'=>url('admin/blog/domain')]
        ]])

        <?php
            $args=[];
            $args['title']='تنظیمات دامنه وبلاگ';
        ?>

        <x-panel-box :args="$args">

            <?php
                $option=['url' => 'admin/blog/domain'];
                $form=new \App\Lib\FormBuilder(null,$option, 'create',[]);
            ?>

            <?php $form->textInput('url','آدرس وبلاگ',['validate'=>'required','class'=>'left'],config('blog.url')); ?>

            <?php $form->checkbox('subdomain','استفاده از ساب دامین',config('blog.subdomain')); ?>

            <?php $form->btn('ثبت','edit'); ?>

            <?php $form->close() ?>

        </x-panel-box>

    </div>

@endsection
