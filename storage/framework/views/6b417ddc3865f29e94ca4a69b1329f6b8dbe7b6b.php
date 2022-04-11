<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
              ['title'=>'پرسش های متداول','url'=>url('admin/common-question')],
              ['title'=>'مدیریت دسته ها','url'=>url('admin/category-common-question')]
         ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('faq::category_common_question._search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']='مدیریت دسته ها';
            $args['route']='admin/category-common-question';
            $args['trashCount']=$trash_common_question_cat_count;
            $args['routeParam']='دسته';
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$CategoryCommonQuestion,
                'columns'=>[
                    ['label'=>'نام دسته','attr'=>'title']
                ],
                'route_param'=>'category-common-question',
                'tableLabel'=>'دسته'
            ]);
            ?>
            <?php echo e($CategoryCommonQuestion->links()); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/faq/resource/views/category_common_question/index.blade.php ENDPATH**/ ?>