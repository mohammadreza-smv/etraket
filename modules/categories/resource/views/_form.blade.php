<div class="panel_content">

    <?php
        $option=['url' => 'admin/category'];
        $data=isset($category) ? $category : [];
        $form=new \App\Lib\FormBuilder($errors,$option, $type,$data);
    ?>

    <?php $form->textInput('name','نام دسته',['validate'=>'required']); ?>

    <?php $form->textInput('ename','نام انگلیسی دسته ',[]); ?>

    <?php $form->textInput('search_url','url دسته ',[]); ?>

    <?php $form->select($catList,'parent_id','انتخاب سردسته ',[]); ?>

    <?php $form->fileInput('pic','تصویر دسته'); ?>

    <?php $form->btn( $type=='create' ? 'ثبت دسته' : 'ویرایش دسته', $type); ?>

    <?php $form->close() ?>

</div>
