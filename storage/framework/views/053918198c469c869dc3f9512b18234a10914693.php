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

        $option=['url' => 'admin/orders','method'=>'get','class'=>'search_form'];
        $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);

        $form->textInput('order_id','شماره سفارش',[],$req->get('order_id',''));

        $form->dateInput('first_date','شروع از تاریخ',
           [],e($req->get('first_date',''))
        );

        $form->dateInput('end_date','تا تاریخ',
           [],
           e($req->get('end_date',''))
        );

        $form->btn( 'جست و جو', 'edit');

        $form->close();

    ?>
 <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/orders/resource/views/search-box.blade.php ENDPATH**/ ?>