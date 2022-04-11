<?php $__env->startSection('content'); ?>

   <div>

       <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت برند ها','url'=>url('admin/brands')]]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

       <?php echo $__env->make('brands::_search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

       <?php
          $args=[];
          $args['title']=' مدیریت برند ها';
          $args['route']='admin/brands';
          $args['trashCount']=$trash_brand_count;
          $args['routeParam']='برند';
       ?>

       <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

           <?php
           \App\Lib\GridView::showTable([
               'dataProvider'=>$brand,
               'columns'=>[
                   ['label'=>'ایکون','attr'=>function($model){
                       if(!empty($model->brand_icon)){
                           $src=url('files/upload/'.$model->brand_icon);
                           return ' <img src="'.$src.'" style="max-width:200px;margin:10px">';
                       }
                   },'html'=>true],
                   ['label'=>'نام برند','attr'=>'brand_name'],
                   ['label'=>'نام انگلیسی برند','attr'=>'brand_ename']
               ],
               'route_param'=>'brands',
               'tableLabel'=>'برند'
           ]);
           ?>

           <?php echo e($brand->links()); ?>


        <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

   </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/brands/resource/views/index.blade.php ENDPATH**/ ?>