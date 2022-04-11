@component('mail::layout')
{{-- Header --}}
@slot('header2')
@component('mail::header', ['url' =>url('/')])
{{ config('shop-info.shop_name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('shop-info.shop_name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
