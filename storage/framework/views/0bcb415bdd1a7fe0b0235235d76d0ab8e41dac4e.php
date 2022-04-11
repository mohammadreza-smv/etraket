<?php if(sizeof($product->Gallery)>0): ?>
    <ul class="gallery_ul">
        <?php $__currentLoopData = $product->Gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($key<3): ?>
               <li>
                 <img src="<?php echo e(url('files/gallery/'.$value->image_url)); ?>" data-toggle="modal" data-target="#product_gallery_box">
               </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if(sizeof($product->Gallery)>2): ?>
        <li class="button"  data-toggle="modal" data-target="#product_gallery_box">
            <div>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </li>
        <?php endif; ?>
    </ul>



<?php endif; ?><?php /**PATH /home/teraketc/AppCode/resources/views/include/Gallery.blade.php ENDPATH**/ ?>