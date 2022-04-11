<notification-btn
   auth="<?php echo e(Auth::check() ? 'yes' : 'no'); ?>"
   theme-type="<?php echo e(view_type=='' ? 'desktop' : 'mobile'); ?>"
   send_status_notification="<?php echo e($sendStatusNotification ? 'yes' : 'no'); ?>"
   mobile="<?php echo e(Auth::check() ? Auth::user()->mobile : ''); ?>"
   product_id="<?php echo e($product->id); ?>"
>
</notification-btn>
<?php /**PATH /home/teraketc/AppCode/modules/productStatusNotification/resource/views/notification-btn.blade.php ENDPATH**/ ?>