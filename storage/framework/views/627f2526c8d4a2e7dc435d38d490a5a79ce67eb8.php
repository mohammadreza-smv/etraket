<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت کد های تخفیف','url'=>url('admin/discount')]]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('discount::_search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']=' مدیریت کد های تخفیف';
            $args['route']='admin/discount';
            $args['trashCount']=$trash_discount_count;
            $args['routeParam']='کد تخفیف';
        ?>


        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php

            \App\Lib\GridView::showTable([
                'dataProvider'=>$discount,
                'columns'=>[
                    ['label'=>'کد تخفیف','attr'=>'code'],
                    ['label'=>'میزان تخفیف','attr'=>function($value){
                        if(!empty($value->amount_discount)){
                            return e( replace_number(number_format($value->amount_discount))).' تومان';
                        }
                        else{
                            return e( replace_number($value->amount_percent)).' درصد';
                        }
                    }],
                    ['label'=>'تاریخ انقضا','attr'=>function($value){
                        $jdf=new \App\Lib\Jdf();
                        return e( $jdf->jdate('Y-n-j',$value->expiry_time) );
                    }]
                ],
                'route_param'=>'discount',
                'tableLabel'=>'کد تخفیف'
            ]);

            ?>

         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/discount/resource/views/index.blade.php ENDPATH**/ ?>