<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت سفارشات','url'=>url('admin/orders')],
             ['title'=>'مدیریت مرسوله ها','url'=>url('admin/orders/submissions')]
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if ($__env->exists('orders::submission.search-box')) echo $__env->make('orders::submission.search-box', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
             $args=[];
             $args['title']=$label;
             $args['route']='admin/orders/'.$label_url;
             $args['trashCount']=$trash_submission_count;
             $args['routeParam']='مرسوله';
             $args['remove_new_record']=true;
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$submissions,
                'columns'=>[
                    [
                        'label'=>'کد مرسوله',
                        'attr'=>function($value){
                            return e(replace_number($value->id));
                        },
                    ],
                    [
                        'label'=>'تاریخ ثبت',
                        'attr'=>function($value){
                            $e=explode(' ',$value->created_at); $e2=explode('-',$e[0]);
                            $jdf=new \App\Lib\Jdf();
                            return e(replace_number($jdf->gregorian_to_jalali($e2[0],$e2[1],$e2[2],'-') ));
                        },
                    ],
                    [
                        'label'=>'تعداد کالا',
                        'attr'=>function($value){
                            return e(replace_number($value->product_sum_product_count));
                        },
                    ],
                    [
                        'label'=>'وضعیت مرسوله',
                        'attr'=>function($value){
                            return e(getOrderStatus($value->send_status));
                        },
                    ]
                ],
                'route_param'=>'orders/submissions',
                'tableLabel'=>'مرسوله',
                'actions'=>[
                    function($value){
                        $url=url('admin/orders/submissions/'.$value->id);
                        return '<a href="'.$url.'" class="router-link"><v-icon>mdi-eye-outline</v-icon></a> ';
                    }
                ]
            ],true);
            ?>

            <?php echo e($submissions->links()); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/orders/resource/views/submissions.blade.php ENDPATH**/ ?>