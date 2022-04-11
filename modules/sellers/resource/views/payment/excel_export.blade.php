@extends('backend-theme::layout')

@section('content')

     <div>

         @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت فروشندگان','url'=>url('admin/sellers/list')],
             ['title'=>' دریافت لیست پرداخت','url'=>url('admin/sellers/pay/export')]
         ]])


         <?php $args=['title'=>'دریافت لیست پرداخت'] ?>

         <x-panel-box :args="$args">
             <p style="color:red;text-align:center;margin-top:10px">
                 در حال حاضر هیچ لیستی برای پرداخت وجود ندارد
             </p>
         </x-panel-box>

     </div>

@endsection
