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

        $option=['url' => request()->url(),'method'=>'GET','class'=>'search_form'];
        $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);

        $form->textInput('submission_id','',['class'=>'form-control','placeholder'=>"کد مرسوله"],$req->get('submission_id',''));


        $form->btn( 'جست و جو', 'edit');

        $form->close();

    ?>
 <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php /**PATH /home2/teraketc/AppCode/modules/orders/resource/views/submission/search-box.blade.php ENDPATH**/ ?>