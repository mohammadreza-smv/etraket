<?php
      $option=['url' => 'admin/sellers/commissions'];
      $data=isset($commission) ? $commission : [];
      $defined_vars=get_defined_vars();
      $form=new \App\Lib\FormBuilder(null,$option, $type,$data,$defined_vars);
?>

@if(sizeof($categories)>0)
    @if(array_key_exists('',$categories))
        <?php unset($categories['']) ?>
    @endif
    <?php $form->select($categories,'cat_id','انتخاب دسته',['dense'=>true]); ?>
@endif

@if(sizeof($brands)>0)
    @if(array_key_exists('',$brands))
        <?php unset($brands['']) ?>
    @endif
    <?php $form->select($brands,'brand_id','انتخاب برند',['dense'=>true]); ?>
@endif


<?php $form->textInput('percentage','درصد کمیسیون',['validate'=>'required','type'=>'number']); ?>

<?php $form->btn( $type=='create' ? 'ثبت اطلاعات' : 'ویرایش اطلاعات', $type); ?>

<?php $form->close(); ?>
