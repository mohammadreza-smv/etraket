<?php

$form->select(
    $catList,
    'cat_id',
    'انتخاب دسته',
    ['dense'=>true],
    request()->get('cat_id',0)
);

?>
<?php /**PATH /home2/teraketc/AppCode/modules/categories/resource/views/products_index.blade.php ENDPATH**/ ?>