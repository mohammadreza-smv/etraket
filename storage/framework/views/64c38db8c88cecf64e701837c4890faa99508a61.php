<?php
     $form1=new \App\Lib\FormBuilder(null,['url' => 'api/seller/first_step_register'], 'create',null);
?>

<?php $form1->textInput('email','ایمیل',['validate'=>'required','prepend_icon'=>'mdi-at','dense'=>false]); ?>

<?php $form1->textInput('mobile','شماره موبایل',['validate'=>'required','prepend_icon'=>'mdi-cellphone','dense'=>false]); ?>

<?php $form1->textInput('password','کلمه عبور',['validate'=>'required','type'=>'password','prepend_icon'=>'mdi-lock','dense'=>false]); ?>

<?php $form1->btn('ثبت نام','edit'); ?>

<?php $form1->close(); ?>
<?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/auth/register/step1.blade.php ENDPATH**/ ?>