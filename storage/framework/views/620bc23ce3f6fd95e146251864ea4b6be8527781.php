<?php $__env->startSection('content'); ?>

    <div>
        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت محموله ها','url'=>url('admin/packages')]]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <?php
        $b1=['title'=>'جست و جو'];
        $b2=['title'=>'مدیریت پرداخت ها'];
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $b1]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <?php echo $__env->make('sellers::payment._search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $b2]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$payments,
                'columns'=>[
                    [
                        'label'=>'شناسه پرداخت',
                        'attr'=>function($value){
                            return e(replace_number($value->shebase));
                        }],
                    [
                        'label'=>'مبلغ پرداخت شده',
                        'attr'=>function($value){
                            return e(get_price($value->price/10));
                        }
                    ],
                    [
                        'label'=>'زمان ثبت',
                        'attr'=>function($value){
                            $jdf=new \App\Lib\Jdf();
                            return e($jdf->jdate('Y-n-j',$value->time) );
                        }
                    ],
                    [
                        'label'=>'فروشنده',
                        'attr'=>function($value){
                            return e($value->seller->brand_name);
                        }
                    ]
                ]
            ],true,true);

            ?>
            <?php echo e($payments->links()); ?>

         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/payment/list.blade.php ENDPATH**/ ?>