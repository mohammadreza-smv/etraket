<?php
   $price=$order_price;
   if(Session::has('discount_value')){
       $price=$price+Session::get('discount_value',0);
   }
?>
<discount-box
    site-name="{{ config('shop-info.shop_name') }}"
    order_price="{{ intval($price) }}"
></discount-box>
