<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',[
             'data'=>[['title'=>'مدیریت محصولات','url'=>url('admin/products')]]
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('products::_search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args['title']='مدیریت محصولات';
            $args['route']='admin/products';
            $args['trashCount']=$trash_product_count;
            $args['routeParam']='محصول';
            $args['progress-param']='admin/products';
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php  $status=\Modules\products\Models\Product::ProductStatus(); define('status',$status); ?>

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$product,
                'columns'=>[
                    ['label'=>'تصویر محصول','attr'=>function($model){
                        $src=url('files/thumbnails/'.$model->image_url);
                        return '<img src="'.$src.'" class="product_pic" style="margin:20px;">';
                    },'html'=>true],
                    ['label'=>'عنوان','attr'=>'title'],
                    ['label'=>'وضعیت محصول','attr'=>function($model){
                        if(array_key_exists($model->status,status)){
                            $class=($model->status==1)  ? "alert-success" : 'alert-warning';
                            return '<span class="'.$class.'" style="font-size:13px;padding:5px 7px;width:80px;display: block;">'.status[$model->status] .'</span>';
                        }
                    },'html'=>true]
                ],
                'route_param'=>'products',
                'tableLabel'=>'محصول'
            ]);
            ?>

            <?php echo e($product->links()); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/products/resource/views/index.blade.php ENDPATH**/ ?>