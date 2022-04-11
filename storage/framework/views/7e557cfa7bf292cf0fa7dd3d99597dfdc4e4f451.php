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

        $option=['url' => 'admin/sellers/commissions','method'=>'get','class'=>'search_form'];

        $form=new \App\Lib\FormBuilder(null,$option, 'create',[]);

    ?>

        <?php if(array_key_exists('',$categories)): ?>
            <?php unset($categories['']) ?>
        <?php endif; ?>

        <?php if(array_key_exists('',$brands)): ?>
            <?php unset($brands['']) ?>
        <?php endif; ?>

    <?php

        $form->select($categories,'cat_id','انتخاب دسته',['dense'=>true],$req->get('cat_id'));

        $form->select($brands,'brand_id','انتخاب برند',['dense'=>true],$req->get('brand_id'));

        $form->btn('جست و جو', 'edit');

        $form->close();

    ?>


 <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/commissions/_search_form.blade.php ENDPATH**/ ?>