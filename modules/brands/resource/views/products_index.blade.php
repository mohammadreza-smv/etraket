<?php

$form->select(
    $brands,
    'brand_id',
    'انتخاب برند ',
    ['dense'=>true],
    request()->get('brand_id',0));

?>
