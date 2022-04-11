<?php $__env->startSection('content'); ?>

     <div>

         <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت فروشندگان','url'=>url('admin/sellers/list')],
             ['title'=>' دریافت لیست پرداخت','url'=>url('admin/sellers/pay/export')]
         ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


         <?php $args=['title'=>'دریافت لیست پرداخت'] ?>

         <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
             <p style="color:red;text-align:center;margin-top:10px">
                 در حال حاضر هیچ لیستی برای پرداخت وجود ندارد
             </p>
          <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

     </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/payment/excel_export.blade.php ENDPATH**/ ?>