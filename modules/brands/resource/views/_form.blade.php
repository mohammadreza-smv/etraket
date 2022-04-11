<div class="panel_content">

    <?php
         $option=['url' => 'admin/brands'];
         $data=isset($brand) ? $brand : [];
         $form=new \App\Lib\FormBuilder(null,$option, $type,$data);
    ?>

    <?php $form->textInput('brand_name','نام برند',['validate'=>'required']); ?>

    <?php $form->textInput('brand_ename','نام انگلیسی برند ',['validate'=>'required','class'=>'left']); ?>

    <?php $form->textarea('tozihat','توضیحات',[]); ?>

    <?php $form->fileInput('pic','انتخاب ایکون برند'); ?>


    @if($type=='edit')
       <div class="form-group">
          <img @if(!empty($brand->brand_icon)) src="{{ url('files/upload/'.$brand->brand_icon) }}" @endif>
       </div>
    @endif

    <?php $form->btn( $type=='create' ? 'ثبت برند' : 'ویرایش برند', $type); ?>

    <?php $form->close(); ?>

</div>
