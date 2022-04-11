<?php

   $form->select($sellers,
       'seller_id',
       'انتخاب فروشنده ',
       ['dense'=>true],
       request()->get('seller_id',0));

?>
<?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/products_index.blade.php ENDPATH**/ ?>