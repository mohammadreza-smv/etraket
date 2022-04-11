<div>
    <?php
       $option=['url' => 'admin/common-question'];
       if($type=='edit'){
           $form=new \App\Lib\FormBuilder(null,$option, $type,$CommonQuestion);
       }
       else{
           $form=new \App\Lib\FormBuilder(null,$option);
       }
    ?>

    <?php $form->textInput('title', 'عنوان پرسش ', ['class'=>'total-width','validate'=>'required']) ?>

    <p>پاسخ کوتاه</p>

    <?php $form->editor('small_answer', []) ?>

    <p>پاسخ</p>

    <?php $form->editor('answer', []); ?>

    <?php $form->select(
        $cat,
        'cat_id',
        'انتخاب دسته',
        []);
    ?>

    <?php $form->checkbox('pin', 'ثبت به عنوان پرسش پر تکرار', false);?>

    <?php $form->btn( $type=='create' ? 'ثبت پرسش' : 'ویرایش پرسش', $type); ?>

    <?php $form->close() ?>

</div>
