<?php

$form->select(
    $catList,
    'cat_id',
    'انتخاب دسته',
    ['dense'=>true],
    request()->get('cat_id',0)
);

?>
