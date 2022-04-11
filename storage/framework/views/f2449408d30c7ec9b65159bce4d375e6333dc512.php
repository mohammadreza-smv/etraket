<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
            ['title'=>'تنظیمات درگاه پرداخت','url'=>url('admin/setting/payment-gateway')],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
        $args=[];
        $args['title']='تنظیمات درگاه پرداخت';
        ?>

        <?php $gateways=run_action('gateway_info',[],true) ?>

        <?php

        $selectList=array();
        foreach ($gateways as $key=>$value){
            $selectList[$value['name']]=$value['title'];
        }
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>


            <?php if(sizeof($gateways)>0): ?>

                <?php
                $option=['url' => 'admin/setting/payment-gateway'];
                $form=new \App\Lib\FormBuilder($errors,$option);
                ?>



                <p style="color: red">درگاه های فعال</p>

                <?php $__currentLoopData = $selectList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $name="action_gateway[$key]" ?>
                    <?php $form->checkbox($name,$value,config('gateway.action_gateway.'.$key,false)); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div style="padding:20px 0px">
                    <?php $form->select($selectList,
                        'gateway',
                        'درگاه پیش فرض ',
                        [],
                        config('gateway.gateway',false)
                    ); ?>
                </div>

                <?php $form->btn('ثبت ', 'create'); ?>

                <?php $form->close(); ?>

            <?php else: ?>
                <p style="text-align: center;padding-top: 20px;color: red">درگاه فعالی یافت نشد</p>
            <?php endif; ?>

         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/setting/resource/views/payment_gateway.blade.php ENDPATH**/ ?>