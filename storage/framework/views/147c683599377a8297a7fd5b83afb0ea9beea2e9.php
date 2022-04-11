
<?php
    if(!isset($submission)){
        $submission=$order->submissions;
    }

?>

<?php use App\Lib\Jdf;use Modules\orders\Models\Orders;
$Jdf=new Jdf();
$OrderStatus=Orders::OrderStatus();
?>
<?php $__currentLoopData = $submission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php
      $args=[];
      $args['title']='جزییات مرسوله - '.replace_number($value->id);
    ?>

    <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

          <?php if ($__env->exists('orders::submission.detail')) echo $__env->make('orders::submission.detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

          <order-step
              :steps="<?php echo e(json_encode($OrderStatus)); ?>"
              :send_status="<?php echo e($value['send_status']); ?>"
              order_id="<?php echo e($value->id); ?>"
          >
              <template v-slot:status_form>

              </template>
          </order-step>

          <?php if ($__env->exists('orders::product-detail')) echo $__env->make('orders::product-detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

          <?php if ($__env->exists('orders::submission.submission-events')) echo $__env->make('orders::submission.submission-events', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

     <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php /**PATH /home2/teraketc/AppCode/modules/orders/resource/views/order-submission.blade.php ENDPATH**/ ?>