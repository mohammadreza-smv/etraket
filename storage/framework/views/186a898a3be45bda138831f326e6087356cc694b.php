<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>
           [['title'=>'مدیریت نقش های کاربری','url'=>url('admin/userRole')]]
       ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <?php
            $args=[];
            $args['title']='مدیریت نقش های کاربری';
            $args['route']='admin/userRole';
            $args['trashCount']=$trash_role_count;
            $args['routeParam']='نقش کاربری';
        ?>
        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$userRole,
                'columns'=>[
                    ['label'=>'نام نقش','attr'=>'name'],
                    ['label'=>'تعداد کاربر','attr'=>function($model){
                        if($model->userrole_count){
                            return replace_number($model->userrole_count);
                        }
                        else{
                            return  replace_number(0);
                        }
                    }],
                ],
                'actions'=>[
                    function($model){
                        $url=url('admin/userRole/access/'.$model->id);
                        return '<a href="'.$url.'" style="color:black" class="router-link">
                              <v-icon>mdi-lock</v-icon>
                            </a> ';
                    }
                ],
                'tableLabel'=>'نقش کاربری',
                'route_param'=>'userRole'
            ]);
            ?>

            <?php echo e($userRole->links()); ?>

         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/users/resource/views/roles/index.blade.php ENDPATH**/ ?>