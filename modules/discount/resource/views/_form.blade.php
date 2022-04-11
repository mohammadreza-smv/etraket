<?php
  $option=['url' => 'admin/discount'];
  $data=isset($discount) ? $discount : [];
  $form=new \App\Lib\FormBuilder($errors,$option, $type,$data);
?>

<?php $form->textInput('code','کد تخفیف ',['class'=>'left','validate'=>'required']); ?>

<?php $form->dateInput('expiry_time','تاریخ انقضا',[]); ?>

<?php $form->numberInput('amount','حداقل خرید',['class'=>'left']); ?>

<?php $form->numberInput('number_usable','حداکثر دفعات استفاده از کد تخغیف',['class'=>'left']); ?>

<?php $form->numberInput('amount_discount','میزان  تخفیف (بر حسب تومان)',['class'=>'left']); ?>

<?php $form->numberInput('amount_percent','میزان تخفیف (بر حسب درصد) ',['class'=>'left']); ?>

<?php $form->btn( $type=='create' ? 'ثبت کد تخفیف' : 'ویرایش کد تخفیف', $type); ?>

<?php $form->close(); ?>
