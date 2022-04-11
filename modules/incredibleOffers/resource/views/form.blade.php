@extends('backend-theme::layout')

@section('content')

   <div>

       @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','url'=>url('admin/products')],
            ['title'=>'مدیریت تنوع های قیمت','url'=>url('admin/product/price_variation?product_id='.$price_variation->product_id)]
       ]])

       <?php
       $args=[];
       $args['title']='ثبت به عنوان پیشنهاد شگفت انگیز';
       ?>


       <x-panel-box :args="$args">

           <?php
                 $option=['url' => 'admin/incredible-offers'];
                 $form=new \App\Lib\FormBuilder($errors,$option, 'edit',$price_variation);
                 $data1=isset($price_variation) ? $price_variation->offers_first_date : '';
                 $data2=isset($price_variation) ? $price_variation->offers_last_date : '';
           ?>

           <?php $form->numberInput('price1','هزینه محصول : ',['validate'=>'required','class'=>'left']); ?>

           <?php $form->numberInput('price2','هزینه محصول برای فروش : ',['validate'=>'required','class'=>'left']); ?>

           <?php $form->numberInput('product_number','تعداد موجودی محصول : ',['validate'=>'required','class'=>'left']); ?>

           <?php $form->numberInput('product_number_cart','تعداد قابل سفارش در سبد خرید : ',['validate'=>'required','class'=>'left']); ?>

           <?php $form->dateInput('date1','تاریخ شروع : ',['validate'=>'required','style'=>'text-align:center'],$data1); ?>

           <?php $form->dateInput('date2','تاریخ پایان : ',['validate'=>'required','style'=>'text-align:center'],$data2); ?>

           <?php $form->btn('ثبت','edit'); ?>

           <?php $form->close(); ?>

       </x-panel-box>

   </div>

@endsection
