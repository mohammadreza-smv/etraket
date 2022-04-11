<?php
   $form2=new \App\Lib\FormBuilder(null,['url' => 'api/seller/second_step_register'], 'create',null);
?>

<?php $form2->textInput('brand_name','نام تجاری',['validate'=>'required','prepend_icon'=>'mdi-bookmark','dense'=>false]); ?>

<?php $form2->textInput('fname','نام کامل مطابق با کارت ملی',['validate'=>'required','prepend_icon'=>'mdi-account-outline','dense'=>false]); ?>

<?php $form2->textInput('lname','نام خانوادگی کامل مطابق با کارت ملی',['validate'=>'required','prepend_icon'=>'mdi-account-outline','dense'=>false]); ?>

<register-location></register-location>

<register-mobile-field :mobile="mobile"></register-mobile-field>

<?php $form2->select(['1'=>'شخصی','2'=>'تجاری'],'account_type','نوع حساب',['validate'=>'required','dense'=>false,'prepend_icon'=>'mdi-check']); ?>

<?php $form2->btn('ثبت و ادامه','edit'); ?>


<?php $form2->close(); ?>
<?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/auth/register/step2.blade.php ENDPATH**/ ?>