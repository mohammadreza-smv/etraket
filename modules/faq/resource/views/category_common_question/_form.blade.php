<div>
    <?php
    $option=['url' => 'admin/category-common-question'];
    if($type=='edit'){
        $form=new \App\Lib\FormBuilder(null,$option, $type,$CategoryCommonQuestion);
    }
    else{
        $form=new \App\Lib\FormBuilder(null,$option);
    }
    ?>

    <?php $form->textInput('title','نام دسته',['validate'=>'required']); ?>

    <?php $url=''; ?>
    @if(isset($CategoryCommonQuestion))
        @php $url=url('files/upload/'.$CategoryCommonQuestion->icon) @endphp
    @endif

    <?php $form->imageInput('pic','انتخاب ایکون ',['class'=>'small'],$url); ?>

    <?php $form->btn( $type=='create' ? 'ثبت دسته' : 'ویرایش دسته', $type); ?>

    <?php $form->close() ?>

</div>
