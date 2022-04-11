<mobile-gallery>
    <?php $__currentLoopData = $product->Gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <v-carousel-item key="<?php echo e($key); ?>">
            <img src="<?php echo e(url('files/gallery/'.$value->image_url)); ?>" class="mobile-gallery">
        </v-carousel-item>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</mobile-gallery>
<?php /**PATH /home/teraketc/AppCode/modules/gallery/resource/views/carousels.blade.php ENDPATH**/ ?>