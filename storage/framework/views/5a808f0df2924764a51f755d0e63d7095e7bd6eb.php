<?php

$option=['url' => 'admin/sellers/payments','method'=>'GET','class'=>'search_form'];
$form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);


$form->select($sellers,'seller_id',null,['dense'=>'true'],false,$req->get('seller_id',''));

$form->dateInput('date','تاریخ پرداخت',
    [],
    e($req->get('date',''))
);

$form->btn( 'جست و جو', 'edit');

$form->close();
 ?><?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/payment/_search.blade.php ENDPATH**/ ?>