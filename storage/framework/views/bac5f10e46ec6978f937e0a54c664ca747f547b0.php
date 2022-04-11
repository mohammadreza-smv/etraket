<?php

   $data=isset($seller) ? $seller : [];
   $defined_vars=get_defined_vars();
   $form=new \App\Lib\FormBuilder(null,['url' =>'admin/sellers/list'], $type,$data,$defined_vars);

   $account_status=[
       'active'=>'فعال',
       'Inactive'=>'غیر فعال',
       'awaiting_approval'=>'در انتظار تایید',
       'reject'=>'رد شده',
   ];
?>


<?php $form->textInput('fname','نام  ',['validate'=>'required']); ?>

<?php $form->textInput('lname','نام خانوادگی ',['validate'=>'required']); ?>

<?php $form->textInput('brand_name','نام فروشگاه ',['validate'=>'required']); ?>

<?php $form->textInput('email','ایمیل ',['validate'=>'required']); ?>

<?php $form->textInput('mobile','شماره موبایل ',['validate'=>'required']); ?>

<?php $form->textInput('password','کلمه عبور ',['type'=>'password']); ?>

<?php $form->select($account_status,'account_status','وضعیت اکانت :',[]); ?>


<?php if($seller): ?>
    <register-location class_name="c-field"
                       province_id="<?php echo e($seller->province_id); ?>" city_id="<?php echo e($seller->city_id); ?>"></register-location>
<?php else: ?>
    <register-location class_name="c-field"></register-location>
<?php endif; ?>

<?php $form->textarea('description','توضیحات فروشگاه',['class'=>'total-width']);  ?>

<?php $form->btn( $type=='create' ? 'ثبت اطلاعات' : 'ویرایش اطلاعات', $type); ?>

<?php $form->close(); ?>
<?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/_form.blade.php ENDPATH**/ ?>