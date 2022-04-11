<?php

$form->select(
    $brands,
    'brand_id',
    'انتخاب برند ',
    ['dense'=>true],
    request()->get('brand_id',0));

?>
<?php /**PATH /home2/teraketc/AppCode/modules/brands/resource/views/products_index.blade.php ENDPATH**/ ?>