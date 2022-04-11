<div class="panel_content">

    <?php
    $option=['url' => 'admin/product/review','query_string'=>'?product_id='.$product->id];
    $data=isset($review) ? $review : [];
    $form=new \App\Lib\FormBuilder($errors,$option, $type,$data);
    ?>

    <?php $form->textInput('title','عنوان ',['class'=>'total-width','validate'=>'required']); ?>

    <?php $form->editor('tozihat',['validate'=>'required']); ?>

    <?php $form->btn( $type=='create' ? 'ثبت نقد و بررسی' : 'ویرایش نقد و بررسی', $type); ?>

    <?php $form->close(); ?>

</div>
