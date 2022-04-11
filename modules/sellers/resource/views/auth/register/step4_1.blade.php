<?php
$form3=new \App\Lib\FormBuilder(null,['url' => 'api/seller/upload_file'], 'create',null);
?>

<register-mobile-field :mobile="mobile"></register-mobile-field>

<input type="hidden" name="account_type" value="1">

<?php $form3->imageInput('shenasname','اسکن صفحه اصلی شناسنامه',['validate'=>'required']); ?>

<?php $form3->imageInput('cart','اسکن کارت ملی',['validate'=>'required']); ?>

<?php $form3->btn('ارسال فایل','edit'); ?>

<?php $form3->close(); ?>
