<brand-info>
    <div class="brand-detail">
        <?php if(!empty($brand->brand_icon)): ?>
            <img src="<?php echo e(url('files/upload/'.$brand->brand_icon)); ?>" />
        <?php endif; ?>
        <a href="<?php echo e(url('brand/'.$brand->brand_ename)); ?>" class="router-link brand-name">
            <?php echo e($brand->brand_name); ?>

        </a>
        <a href="<?php echo e(url('brand/'.$brand->brand_ename)); ?>" class="router-link brand-link">
            <?php echo e(url('brand/'.$brand->brand_ename)); ?>

        </a>
    </div>
</brand-info>
<?php /**PATH /home2/teraketc/AppCode/modules/brands/resource/views/shop/brand-info.blade.php ENDPATH**/ ?>