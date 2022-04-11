<?php $__env->startSection('content'); ?>


    <div>

        <?php
             $args1=['title'=>'نمودار میزان فروش این ماه فروشگاه'];
             $args2=['title'=>'آخرین سفارشات شما'];
        ?>

        <div style="margin:15px">
            <?php if($seller->account_status=='awaiting_approval'): ?>
                <v-alert type="error">
                    در انتظار تایید حساب کاربری
                </v-alert>
            <?php endif; ?>

            <?php if($seller->account_status=='Inactive'): ?>
                <v-alert type="error">
                    حساب کاربری شما غیر فعال می باشد
                </v-alert>
            <?php endif; ?>
        </div>


        <?php if (isset($component)) { $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde = $component; } ?>
<?php $component = $__env->getContainer()->make(Modules\sellers\components\PanelBox::class, ['args' => $args1]); ?>
<?php $component->withName('seller-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <month-sales-statistics></month-sales-statistics>
         <?php if (isset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde)): ?>
<?php $component = $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde; ?>
<?php unset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>


        <?php if (isset($component)) { $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde = $component; } ?>
<?php $component = $__env->getContainer()->make(Modules\sellers\components\PanelBox::class, ['args' => $args2]); ?>
<?php $component->withName('seller-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <?php if ($__env->exists('sellers::panel.orders.list',['orders'=>$latsOrders])) echo $__env->make('sellers::panel.orders.list',['orders'=>$latsOrders], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php if (isset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde)): ?>
<?php $component = $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde; ?>
<?php unset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/panel/index.blade.php ENDPATH**/ ?>