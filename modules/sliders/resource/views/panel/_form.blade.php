<div class="panel_content">
    <?php
    $option=['url' => 'admin/sliders','files'=>true];
    $data=isset($slider) ? $slider : [];
    $form=new \App\Lib\FormBuilder($errors,$option, $type,$data);
    ?>

    <?php $form->textInput('title','عنوان ',['class'=>'total-width']); ?>

    <?php $form->textInput('url','آدرس (url)',['class'=>'left total-width']); ?>



    <?php $url1=''; ?>

    @if(isset($slider))
        @php $url1=url('files/slider/'.$slider->image_url) @endphp
    @endif

    <?php $form->imageInput('pic','انتخاب تصویر اسلایدر',[],$url1); ?>

    <div style="margin-bottom:20px;">
        <?php $url2=''; ?>
        @if(isset($slider) && !empty($slider->mobile_image_url))
            @php $url2=url('files/slider/'.$slider->mobile_image_url) @endphp
        @endif
    </div>

    <?php $form->imageInput('mobile_pic','انتخاب تصویر اسلایدر برای نمایش در گوشی موبایل',[],$url2); ?>

    <?php $form->btn( $type=='create' ? 'ثبت اسلایدر' : 'ویرایش اسلایدر', $type); ?>


    <?php $form->close() ?>

</div>
