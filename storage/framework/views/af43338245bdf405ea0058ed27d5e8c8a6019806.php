<?php

$OrderStatus=\Modules\orders\Models\Orders::OrderStatus();
$args=['title'=>'جزییات سفارش']

?>

<?php if (isset($component)) { $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\UserPanelBox::class, ['args' => $args]); ?>
<?php $component->withName('user-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php if ($__env->exists('orders::userpanel.order-global-info')) echo $__env->make('orders::userpanel.order-global-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <?php if (isset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950)): ?>
<?php $component = $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950; ?>
<?php unset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php $i=1; ?>

<?php $__currentLoopData = $order->submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php

    $args=[];
    if(view_type!='mobile'){
        $args['title']='مرسوله '.replace_number($i).' از '.replace_number(sizeof($order->submissions)).'';
    }
    ?>

    <?php if (isset($component)) { $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\UserPanelBox::class, ['args' => $args]); ?>
<?php $component->withName('user-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

         <?php $__env->slot('header'); ?> 
            <span>مرسوله </span>
            <span><?php echo e(replace_number($i)); ?> </span>
            از
            <span><?php echo e(replace_number(sizeof($order->submissions))); ?></span>

            <span style="color:<?= $value['send_status']>0 ? 'green' : 'red' ?>">
                      (<?php echo e(getOrderStatus([$value['send_status']])); ?>)
                </span>

         <?php $__env->endSlot(); ?>
        <div style="margin: 20px">

            <?php if ($__env->exists('orders::submission.detail')) echo $__env->make('orders::submission.detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php if(view_type!='mobile'): ?>
                <order-step
                    :steps="<?php echo e(json_encode($OrderStatus)); ?>"
                    :send_status="<?php echo e($value['send_status']); ?>"
                ></order-step>
            <?php endif; ?>

            <?php $__currentLoopData = $value->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($row->product): ?>
                    <div class="product-detail-row">
                        <div class="img-box">
                            <a href="<?php echo e(shop_product_url($row->product)); ?>">
                                <img src="<?php echo e(url('files/thumbnails/'.$row->product->image_url)); ?>"/>
                            </a>
                        </div>

                        <div class="product-detail">
                            <div class="item">
                                <?php echo e($row->product->title); ?>

                            </div>
                            <div class="item">
                                <?php if($row->param1_type=='Modules\\colors\\Models\\Color'): ?>
                                    <span class="color" style="background-color:#<?= $row->param1->code ?>"></span>
                                    <?php echo e($row->param1->name); ?>


                                <?php elseif($row->param1_type=='Modules\\warranty\\Models\\Warranty'): ?>
                                    <?php echo e($row->param1->name); ?>

                                <?php elseif($row->param1_type=='Modules\\priceVariation\\Models\\PriceVariationItems'): ?>
                                    <?php echo e($row->param1->variation_name); ?> : <?php echo e($row->param1->variation_value); ?>

                                <?php endif; ?>
                            </div>

                            <div class="item">
                                <?php if($row->param2_type=='Modules\\colors\\Models\\Color'): ?>
                                    <span class="color" style="background-color:#<?= $row->param2->code ?>"></span>
                                    <?php echo e($row->param2->name); ?>


                                <?php elseif($row->param2_type=='Modules\\warranty\\Models\\Warranty'): ?>
                                    <?php echo e($row->param2->name); ?>

                                <?php elseif($row->param2_type=='Modules\\priceVariation\\Models\\PriceVariationItems'): ?>
                                    <?php echo e($row->param2->variation_name); ?> : <?php echo e($row->param2->variation_value); ?>

                                <?php endif; ?>
                            </div>

                            <?php if($row->seller): ?>
                                <div class="item">
                                    <span>فروشنده : </span>
                                    <span><?php echo e($row->seller->brand_name); ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="item">
                                <span>تعداد : </span>
                                <span><?php echo e(replace_number($row->product_count)); ?></span>
                            </div>

                            <div class="item">
                                <span>قیمت واحد : </span>
                                <span><?php echo e(get_price($row->product_price2)); ?></span>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
     <?php if (isset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950)): ?>
<?php $component = $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950; ?>
<?php unset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    <?php $i++; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/teraketc/AppCode/modules/orders/resource/views/userpanel/order-detail-view.blade.php ENDPATH**/ ?>