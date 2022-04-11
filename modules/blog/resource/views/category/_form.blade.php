<div class="panel_content">

    <?php
        $option=['url' => 'admin/blog/categories'];
        $data=isset($category) ? $category : [];
        $form=new \App\Lib\FormBuilder(null,$option, $type,$data);
    ?>

    <?php $form->textInput('name','نام دسته',['validate'=>'required']); ?>

    <?php $form->select($categories,'parent_id','انتخاب سردسته ',['dense'=>true,'validate'=>'required']); ?>

    <?php $form->textarea('description','توضیحات(حداکثر ۱۵۰ کاراکتر)',[]); ?>

    <?php $form->tagBox('tags','برچسب ها',['class'=>'c-field']); ?>

    <?php $form->btn( $type=='create' ? 'ثبت دسته' : 'ویرایش دسته', $type); ?>

    <?php $form->close() ?>

</div>
