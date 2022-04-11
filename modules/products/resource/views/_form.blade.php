<?php
  $status=\Modules\products\Models\Product::ProductStatus();
  $hide_fields=isset($filters) ? $filters : [];
  $url=isset($url) ? $url :  'admin/products';
?>

<div class="panel_content">
    <?php
       $option=['url' =>$url,'files'=>true];
       $data=isset($product) ? $product : [];
       $form=new \App\Lib\FormBuilder($errors,$option, $type,$data);
    ?>

    <?php $form->textInput('title','عنوان محصول',['validate'=>'required','class'=>'total-width']); ?>

    <?php $form->editor('tozihat',[]); ?>

    <?php
         $product_url=' ';
         if (isset($product)){
             $url=get_url($product->title);
             if($product->product_url!==$url){
                 $product_url=$product->product_url;
             }
         }
    ?>
    <?php $form->textInput('product_url','آدرس محصول',['class'=>'total-width'],$product_url); ?>

    <div class="row">

        <div class="col-md-6">

            <?php $form->textInput('ename','نام لاتین محصول ',['class'=>'total-width']); ?>

            <?php $form->fieldLocation('product_form_right_box') ?>
            @if(array_search('status',$hide_fields)===false)
                 <?php $form->select($status,'status','وضعیت محصول ',['class'=>'total-width','validate'=>'required'],0); ?>
            @endif

        </div>

        <div class="col-md-6">

            <div class="choice_pic_box" style="padding:20px">

                <?php $url=''; ?>
                @if(isset($product))
                    @php $url=url('files/products/'.$product->image_url) @endphp
                @endif

               <?php $form->imageInput('pic','تصویر محصول',[],$url); ?>

            </div>

            <?php $form->fieldLocation('product_form_left_box') ?>

        </div>

    </div>


    <p class="message_text">برچسب ها با استفاده از (،) از هم جدا شود</p>

    <div style="margin-bottom:20px">
        <?php $form->tagBox('keywords','برچسب ها',[]); ?>
    </div>

    <?php $form->textarea('description','توضیحات مختصر در مورد محصول (حداکثر 150 کاراکتر)',['class'=>'total-width']); ?>

    <?php $form->checkbox('fake','کالای غیر اصل',[]); ?>

    <?php $form->btn( $type=='create' ? 'ثبت محصول' : 'ویرایش محصول', $type); ?>

    <?php $form->close(); ?>

</div>
