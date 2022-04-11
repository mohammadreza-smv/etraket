@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'تنظیمات درگاه پرداخت','url'=>url('admin/setting/payment-gateway')],
        ]])

        <?php
        $args=[];
        $args['title']='تنظیمات درگاه پرداخت';
        ?>

        <?php $gateways=run_action('gateway_info',[],true) ?>

        <?php

        $selectList=array();
        foreach ($gateways as $key=>$value){
            $selectList[$value['name']]=$value['title'];
        }
        ?>

        <x-panel-box :args="$args">


            @if(sizeof($gateways)>0)

                <?php
                $option=['url' => 'admin/setting/payment-gateway'];
                $form=new \App\Lib\FormBuilder($errors,$option);
                ?>



                <p style="color: red">درگاه های فعال</p>

                @foreach($selectList as $key=>$value)
                    <?php $name="action_gateway[$key]" ?>
                    <?php $form->checkbox($name,$value,config('gateway.action_gateway.'.$key,false)); ?>
                @endforeach

                <div style="padding:20px 0px">
                    <?php $form->select($selectList,
                        'gateway',
                        'درگاه پیش فرض ',
                        [],
                        config('gateway.gateway',false)
                    ); ?>
                </div>

                <?php $form->btn('ثبت ', 'create'); ?>

                <?php $form->close(); ?>

            @else
                <p style="text-align: center;padding-top: 20px;color: red">درگاه فعالی یافت نشد</p>
            @endif

        </x-panel-box>

    </div>

@endsection
