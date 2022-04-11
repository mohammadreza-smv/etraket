<?php
$form4=new \App\Lib\FormBuilder(null,['url' => 'api/seller/upload_file'], 'create',null);
?>

<register-mobile-field :mobile="mobile"></register-mobile-field>

<input type="hidden" name="account_type" value="2">

<?php $form4->imageInput('shenasname','اسکن صفحه اصلی شناسنامه',['validate'=>'required']); ?>

<?php $form4->imageInput('cart','اسکن کارت ملی',['validate'=>'required']); ?>

<?php $form4->imageInput('rooznamepic','اسکن روزنامه رسمی',['validate'=>'required']); ?>

<?php $form4->btn('ارسال فایل','edit'); ?>

<?php $form4->close(); ?>
<?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/auth/register/step4_2.blade.php ENDPATH**/ ?>