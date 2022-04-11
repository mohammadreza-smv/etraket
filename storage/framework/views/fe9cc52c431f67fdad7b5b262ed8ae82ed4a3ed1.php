<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت صفحات اضافی','url'=>url('admin/pages')]]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('pages::panel._search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']='مدیریت صفحات اضافی';
            $args['route']='admin/pages';
            $args['trashCount']=$trash_page_count;
            $args['routeParam']='صفحه';
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$pages,
                'columns'=>[
                    ['label'=>'عنوان صفحه','attr'=>'title'],
                ],
                'tableLabel'=>'صفحه اضافی',
                'route_param'=>'pages',
                'actions'=>[
                    function($model){
                        $url=url('page/'.$model->url);
                        return '<a href="'.$url.'"  target="_blank" style="color:#000">
                                    <v-icon>mdi-eye</v-icon>
                                 </a> ';
                    }
                ]
            ]);
            ?>

            <?php echo e($pages->links()); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/pages/resource/views/panel/index.blade.php ENDPATH**/ ?>