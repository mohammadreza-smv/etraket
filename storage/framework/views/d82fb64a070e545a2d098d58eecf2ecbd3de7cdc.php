<?php
$data=isset($post) ? $post : [];
$status=[0=>'پیش نویش',1=>'منتشر شده'];
$form=new \App\Lib\FormBuilder(null,['url'=>'admin/blog/posts'], $type,$data);
?>

<?php $form->textInput('title','عنوان',['validate'=>'required','class'=>'total-width']); ?>

<?php $form->editor('content',[]); ?>

<div class="row">

    <div class="col-md-6">

        <?php $form->select($categories,'cat_id','انتخاب دسته ',['class'=>'total-width','validate'=>'required','dense'=>true]); ?>

        <?php $form->select($status,'status','وضعیت ',['class'=>'total-width','validate'=>'required','dense'=>true],1); ?>

        <p class="message_text">برچسب ها با استفاده از (،) از هم جدا شود</p>

        <?php $form->tagBox('keywords','برچسب ها',[]); ?>

    </div>

    <div class="col-md-6">

        <div class="choice_pic_box" style="padding:20px">

            <?php $url=''; ?>
            <?php if(isset($post)): ?>
                <?php $url=url('files/posts/'.$post->pic) ?>
            <?php endif; ?>

            <?php $form->imageInput('pic','تصویر شاخص',[],$url); ?>

        </div>

    </div>

</div>

<div style="margin-top:20px">
    <?php $form->textarea('description','توضیحات مختصر در مورد پست (حداکثر 150 کاراکتر)',['class'=>'total-width']); ?>
</div>

<?php $form->btn( $type=='create' ? 'ثبت' : 'ویرایش', $type); ?>

<?php $form->close(); ?>
<?php /**PATH /home2/teraketc/AppCode/modules/blog/resource/views/post/_form.blade.php ENDPATH**/ ?>