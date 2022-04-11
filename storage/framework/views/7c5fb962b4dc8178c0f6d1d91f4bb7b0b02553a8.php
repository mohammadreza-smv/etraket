<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
           ['title'=>'مدیریت نقد و بررسی ها','url'=>url('admin/product/review?product_id='.$product->id)]
          ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php

             $title='مدیریت نقد و بررسی ها '.e($product->title);
             $args=[];
             $args['title']=$title;
             $args['route']='admin/product/review';
             $args['trashCount']=$trash_review_count;
             $args['routeParam']='نقد و بررسی';
             $args['queryString']=['param'=>'product_id','value'=>$product->id]

        ?>


        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <v-btn style="margin-bottom: 20px" color="primary">
                <a  class="router-link" style="color: white;text-decoration: none" href="<?php echo e(url('admin/product/review/primary?product_id='.$product->id)); ?>">افزودن توضیحات اولیه</a>
            </v-btn>

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$review,
                'columns'=>[
                    ['label'=>'عنوان نقد و بررسی','attr'=>'title']
                ],
                'tableLabel'=>'نقد و بررسی',
                'route_param'=>'product/review',
                'route_query_string'=>'?product_id='.$product->id
            ]);
            ?>

            <?php echo e($review->links()); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>


    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/review/resource/views/panel/index.blade.php ENDPATH**/ ?>