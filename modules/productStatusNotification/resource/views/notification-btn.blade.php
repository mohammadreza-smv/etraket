<notification-btn
   auth="{{ Auth::check() ? 'yes' : 'no' }}"
   theme-type="{{ view_type=='' ? 'desktop' : 'mobile' }}"
   send_status_notification="{{ $sendStatusNotification ? 'yes' : 'no' }}"
   mobile="{{ Auth::check() ? Auth::user()->mobile : '' }}"
   product_id="{{ $product->id }}"
>
</notification-btn>
