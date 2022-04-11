<?php
      $option=['url' => 'admin/sellers/commissions'];
      $data=isset($commission) ? $commission : [];
      $defined_vars=get_defined_vars();
      $form=new \App\Lib\FormBuilder(null,$option, $type,$data,$defined_vars);
?>

<?php if(sizeof($categories)>0): ?>
    <?php if(array_key_exists('',$categories)): ?>
        <?php unset($categories['']) ?>
    <?php endif; ?>
    <?php $form->select($categories,'cat_id','انتخاب دسته',['dense'=>true]); ?>
<?php endif; ?>

<?php if(sizeof($brands)>0): ?>
    <?php if(array_key_exists('',$brands)): ?>
        <?php unset($brands['']) ?>
    <?php endif; ?>
    <?php $form->select($brands,'brand_id','انتخاب برند',['dense'=>true],'0'); ?>
<?php endif; ?>


<?php $form->textInput('percentage','درصد کمیسیون',['validate'=>'required','type'=>'number']); ?>

<?php $form->textInput('max_amount','حداکثر میزان کمیسیون(بر حسب تومان)',['validate'=>'required','type'=>'number']); ?>

<?php $form->btn( $type=='create' ? 'ثبت اطلاعات' : 'ویرایش اطلاعات', $type); ?>

<?php $form->close(); ?>
<?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/commissions/_form.blade.php ENDPATH**/ ?>