<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
            ['title'=>'تنظیمات اتصال به درگاه زرین پال','url'=>url('admin/setting/gateway/zarinpal')],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']='تنظیمات اتصال به درگاه زرین پال';
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php
            $option=['url' => 'admin/setting/gateway/zarinpal'];
            $form=new \App\Lib\FormBuilder($errors,$option);
            ?>

            <?php $form->textInput('MerchantID','MerchantID',['validate'=>'required'],$data['MerchantID']); ?>

            <?php $form->btn('ثبت ', 'create'); ?>

            <?php $form->close(); ?>

         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/ZarinPalGateway/resource/views/setting.blade.php ENDPATH**/ ?>