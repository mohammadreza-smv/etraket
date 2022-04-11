<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت کاربران','url'=>url('admin/users')]]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('users::panel._search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']='مدیریت کاربران';
            $args['route']='admin/users';
            $args['trashCount']=$trash_user_count;
            $args['routeParam']='کاربر';
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$users,
                'columns'=>[
                    ['label'=>'نام کاربر','attr'=>function($model){
                        if (!empty($model->name)){
                            return  e($model->name);
                        }
                        else{
                            return 'ثبت نشده' ;
                        }
                    }],
                    ['label'=>'شماره موبایل','attr'=>function($model){
                        return e(replace_number($model->mobile));
                    }],
                    ['label'=>'تاریخ عضویت','attr'=>function($model){
                        $Jdf=new \App\Lib\Jdf();
                        $e=explode(' ',$model->created_at);
                        $e2=explode('-',$e[0]);
                        return e(replace_number($Jdf->gregorian_to_jalali($e2[0],$e2[1],$e2[2],'-')) );
                    }],
                    ['label'=>'وضعیت','attr'=>function($model){
                        if ($model['account_status']=='active'){
                            return  '<span class="alert alert-success">فعال</span>';
                        }
                        else{
                            return '<span class="alert alert-danger">غیر فعال</span>';
                        }
                    },'html'=>true],
                    ['label'=>'نقش کاربری','attr'=>function($model){
                        if ($model->getRole){
                            return e($model->getRole->name);
                        }
                        elseif($model->role=='admin'){
                            return  'مدیر';
                        }
                        else{
                            return  ' کاربر عادی';
                        }
                    }]
                ],
                'route_param'=>'users',
                'tableLabel'=>'کاربر',
                'tableCssClass'=>'user_table'
            ]);
            ?>
            <?php echo e($users->links()); ?>

         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>


    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/users/resource/views/panel/index.blade.php ENDPATH**/ ?>