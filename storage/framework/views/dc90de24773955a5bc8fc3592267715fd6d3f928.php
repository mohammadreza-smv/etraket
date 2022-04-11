<?php $__env->startSection('content'); ?>

   <div>

       <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','url'=>url('admin/products')],
            ['title'=>'مدیریت تنوع های قیمت','url'=>url('admin/product/price_variation?product_id='.$price_variation->product_id)]
       ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

       <?php
       $args=[];
       $args['title']='ثبت به عنوان پیشنهاد شگفت انگیز';
       ?>


       <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

           <?php
                 $option=['url' => 'admin/incredible-offers'];
                 $form=new \App\Lib\FormBuilder($errors,$option, 'edit',$price_variation);
                 $data1=isset($price_variation) ? $price_variation->offers_first_date : '';
                 $data2=isset($price_variation) ? $price_variation->offers_last_date : '';
           ?>

           <?php $form->numberInput('price1','هزینه محصول : ',['validate'=>'required','class'=>'left']); ?>

           <?php $form->numberInput('price2','هزینه محصول برای فروش : ',['validate'=>'required','class'=>'left']); ?>

           <?php $form->numberInput('product_number','تعداد موجودی محصول : ',['validate'=>'required','class'=>'left']); ?>

           <?php $form->numberInput('product_number_cart','تعداد قابل سفارش در سبد خرید : ',['validate'=>'required','class'=>'left']); ?>

           <?php $form->dateInput('date1','تاریخ شروع : ',['validate'=>'required','style'=>'text-align:center'],$data1); ?>

           <?php $form->dateInput('date2','تاریخ پایان : ',['validate'=>'required','style'=>'text-align:center'],$data2); ?>

           <?php $form->btn('ثبت','edit'); ?>

           <?php $form->close(); ?>

        <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

   </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/incredibleOffers/resource/views/form.blade.php ENDPATH**/ ?>