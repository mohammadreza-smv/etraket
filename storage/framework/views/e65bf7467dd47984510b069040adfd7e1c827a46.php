<?php $__env->startSection('content'); ?>

    <div>
        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت محصولات','url'=>url('admin/products')],
            ['title'=>'ویرایش محصول','url'=>url('admin/products/'.$product->id.'/edit')]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
           $status=\Modules\products\Models\Product::ProductStatus();
           $jdf=new App\Lib\Jdf();
        ?>
        <div class="panel">

            <div class="header">
                ویرایش محصول - <?php echo e($product->title); ?>

            </div>

            <?php echo $__env->make('products::_form',['type'=>'edit'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/products/resource/views/edit.blade.php ENDPATH**/ ?>