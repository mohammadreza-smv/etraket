<?php
   $price=$order_price;
   if(Session::has('discount_value')){
       $price=$price+Session::get('discount_value',0);
   }
?>
<discount-box
    site-name="<?php echo e(config('shop-info.shop_name')); ?>"
    order_price="<?php echo e(intval($price)); ?>"
></discount-box>
<?php /**PATH /home2/teraketc/AppCode/modules/discount/resource/views/box-view.blade.php ENDPATH**/ ?>