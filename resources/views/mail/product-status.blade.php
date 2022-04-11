@component('mail::message')
<?php
   $status=App\Product::ProductStatus();
?>
# وضعیت محصول با عنوان {{ $product_title }} به حالت {{ $status[$product_status] }} تغییر پیدا کرد

@if(!empty($message))
@component('mail::panel')
   {{ $message }}
@endcomponent

@endif

@component('mail::button', ['url' => url(''),'color' => 'success'])
ورود به بخش مدیریت محصولات
@endcomponent


@endcomponent