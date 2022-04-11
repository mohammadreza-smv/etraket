<div class="sidenav">
    <img src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>">
    <p>فروشگاه <?php echo e(config('shop-info.shop_name')); ?></p>
    <ul style="padding:0px">
        <?php $__currentLoopData = $catList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a class="parent_cat">
                    <?php echo e($value->name); ?>


                    <v-icon>mdi-chevron-down</v-icon>
                </a>
                <?php if(sizeof($value->getChild)>0): ?>
                    <div class="li_div">
                        <ul>
                            <?php $__currentLoopData = $value->getChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2=>$value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($value2->notShow==0): ?>
                                    <li>
                                        <div class="child_cat">
                                            <a  <?php if(sizeof($value2->getChild)==0): ?> class="router-link" href="<?php echo e(get_cat_url($value2)); ?>"
                                                <?php endif; ?>>
                                                <span><?php echo e($value2->name); ?></span>
                                                <?php if(sizeof($value2->getChild)>0): ?>
                                                    <v-icon>mdi-chevron-down</v-icon>
                                                <?php endif; ?>
                                            </a>
                                        </div>

                                        <ul>
                                            <?php $__currentLoopData = $value2->getChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key3=>$value3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($value3->notShow==0): ?>
                                                    <li>
                                                        <a style="color:#515151" class="router-link" href="<?php echo e(get_cat_url($value3)); ?>"><?php echo e($value3->name); ?></a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </li>

                                <?php else: ?>
                                    <?php $__currentLoopData = $value2->getChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key3=>$value3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value3->notShow==0): ?>
                                            <li>
                                                <div class="child_cat">
                                                    <a  <?php if(sizeof($value3->getChild )==0): ?> class="router-link"  href="<?php echo e(get_cat_url($value3)); ?>" <?php endif; ?>>
                                                        <span><?php echo e($value3->name); ?></span>
                                                        <?php if(sizeof($value3->getChild)>0): ?>
                                                            <v-icon>mdi-chevron-down</v-icon>
                                                        <?php endif; ?>
                                                    </a>
                                                </div>
                                                <ul>
                                                    <?php $__currentLoopData = $value3->getChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key4=>$value4): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($value4->notShow==0): ?>
                                                            <li>
                                                                <a style="color:#515151" class="router-link" href="<?php echo e(get_cat_url($value4)); ?>"><?php echo e($value4->name); ?></a>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php /**PATH /home2/teraketc/AppCode/themes/theme1/views/mobile/catList.blade.php ENDPATH**/ ?>