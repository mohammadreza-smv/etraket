<?php
   $args=[];
   $args['title']='جست و جو';
?>

<?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <?php

        $option=['url' => 'admin/products','method'=>'get','class'=>'search_form'];

        $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);

        $product_status=\Modules\products\Models\Product::ProductStatus();

        $orderByList=CompleteData('product_list_ordering',['new'=>'جدید ترین محصولات']);

    ?>

    <?php

        $form->textInput('string','عنوان محصول',[],$req->get('string',''));

        $form->select($orderByList,'order_by','مرتب سازی بر اساس',['dense'=>true],$req->get('order_by','new'));

        $form->select($product_status,'status','وضعیت محصول',['dense'=>true],$req->get('status',1));

        $form->btn('جست و جو', 'edit');

        $form->close();

    ?>


 <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/products/resource/views/_search_form.blade.php ENDPATH**/ ?>