<?php

   $form->select($sellers,
       'seller_id',
       'انتخاب فروشنده ',
       ['dense'=>true],
       request()->get('seller_id',0));

?>
