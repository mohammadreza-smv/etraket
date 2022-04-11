<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',[
             'data'=>[['title'=>'لیست محصولات در انتظار موجود شدن','url'=>url('admin/notification/products')]]
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('productStatusNotification::_search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']='لیست محصولات در انتظار موجود شدن';
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>


            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$products,
                'columns'=>[
                    ['label'=>'تصویر محصول','attr'=>function($model){
                        $src=url('files/thumbnails/'.$model->image_url);
                        return '<a href="'.shop_product_url($model).'" target="_blank"><img src="'.$src.'"
                        class="product_pic" style="margin:20px;"></a>';
                    },'html'=>true],
                    ['label'=>'عنوان','attr'=>function($model){
                        return $model->title;
                    }],
                    ['label'=>'تعداد درخواست','attr'=>function($model){
                           return replace_number($model->request_count);
                    }],
                ],
                'route_param'=>'products',
                'tableLabel'=>'محصول'
            ],true,true);
            ?>

            <?php echo e($products->links()); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/productStatusNotification/resource/views/products.blade.php ENDPATH**/ ?>