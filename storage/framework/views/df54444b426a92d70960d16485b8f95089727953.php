<?php
   $args=[];
   $args['title']='جست و جو';
   $url=isset($url) ? $url : 'sellers/panel/products';
?>

<?php if (isset($component)) { $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde = $component; } ?>
<?php $component = $__env->getContainer()->make(Modules\sellers\components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('seller-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <?php
        $option=['url' =>$url,'method'=>'get','class'=>'search_form'];

        $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);
    ?>

    <?php

        $form->textInput('search_text','عنوان محصول',[],$req->get('search_text',''));

        $form->btn('جست و جو', 'edit');

        $form->close();

    ?>


 <?php if (isset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde)): ?>
<?php $component = $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde; ?>
<?php unset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/panel/products/_search_form.blade.php ENDPATH**/ ?>