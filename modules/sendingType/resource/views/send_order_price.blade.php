@extends('backend-theme::layout')

@section('content')

   <div>

       @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'تعیین هزینه ارسال سفارشات','url'=>url('admin/setting/send-order-price')],
       ]])

       <?php
       $args=[];
       $args['title']='تعیین هزینه ارسال سفارشات';
       ?>

       <x-panel-box :args="$args">

           <?php
           $option=['url' => 'admin/setting/order/send-price'];
           $form=new \App\Lib\FormBuilder($errors,$option);
           ?>

           @foreach($send_types as $type)
               <p class="send_type_name">تعیین هزینه  برای {{ $type->type_name }}</p>

               <?php $form->numberInput(
                   $type->type_key.'_send_time',
                   'زمان حدودی ارسال سفارش ',
                   ['class'=>'left'],
                   $data[$type->type_key.'_send_time']
               ); ?>

               @if($type->price_type==0)
                   @php $label="هزینه ارسال سفارش"  @endphp
               @else
                   @php $label="حداقل هزینه ارسال سفارش"  @endphp
               @endif


               <?php $form->numberInput(
                   $type->type_key.'_send_price',
                   $label,
                   ['class'=>'left'],
                   $data[$type->type_key.'_send_price']
               ); ?>

               <?php $form->numberInput(
                   $type->type_key.'_min_order_price',
                   'حداقل خرید برای ارسال رایگان',
                   ['class'=>'left'],
                   $data[$type->type_key.'_min_order_price']
               ); ?>

           @endforeach

           <?php $form->btn('ثبت', 'create'); ?>

           <?php $form->close(); ?>

       </x-panel-box>

   </div>


@endsection

