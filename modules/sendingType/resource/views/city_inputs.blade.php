<p style="color:red;font-size:13px">ثبت اطلاعات ارسال سفارشات به این شهر (در صورت نیاز)</p>

@foreach($sending_type as $type)
    <p class="send_type_name">تعیین هزینه  برای {{ $type->type_name }}</p>

    <?php
      $form->numberInput($type->type_key.'_send_time','زمان حدودی ارسال سفارش :',['class'=>'form-control left']);
    ?>
    @if($type->price_type==0)
        @php $label="هزینه ارسال سفارش :"  @endphp
    @else
        @php $label="حداقل هزینه ارسال سفارش :"  @endphp
    @endif

    <?php
       $form->numberInput($type->type_key.'_send_price',$label,['class'=>'form-control left']);
    ?>
    <?php
       $form->numberInput($type->type_key.'_min_order_price','حداقل خرید برای ارسال رایگان :',['class'=>'form-control left']);
    ?>
@endforeach
