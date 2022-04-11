
    <?php
        $url=isset($url) ? $url : 'admin/product/price_variation';
        $option=['url' => $url,'query_string'=>'?product_id='.$product->id];
        $data=isset($price_variation) ? $price_variation : [];
        $form=new \App\Lib\FormBuilder(null,$option, $type,$data);
    ?>


    <?php $form->numberInput('price1','قیمت محصول',['class'=>'left']); ?>

    <?php $form->numberInput('price2','قیمت محصول برای فروش ',['class'=>'left']); ?>

    <?php $form->numberInput('product_number','تعداد موجودی محصول ',['class'=>'left']); ?>

    <?php $form->numberInput('product_number_cart','تعداد سفارش در سبد خرید ',['class'=>'left']); ?>

    <?php $form->numberInput('send_time','زمان آماده سازی محصول ',['class'=>'left']); ?>

    <?php $form->btn( $type=='create' ? 'ثبت تنوع قیمت' : 'ویرایش تنوع قیمت', $type); ?>

    <?php $form->close(); ?>
<?php /**PATH /home/teraketc/AppCode/modules/priceVariation/resource/views/panel/_form.blade.php ENDPATH**/ ?>