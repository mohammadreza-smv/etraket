<shop-nav>
    <div class="shopCategory">
        <ul class="shop_menu_ul">
            <li class="cat_hover">
                <div></div>
            </li>
            <li class="shop_nav_li" id="show_cat_list">
                <span class="fa fa-bars"></span>
                <span>دسته بندی ها</span>

                <div class="cat-list-div">
                    <div class="cat_list_box">
                        <div class="parent_list">
                            <ul class="list-inline cat_list">
                                <?php $__currentLoopData = $catList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li  data-index="<?php echo e($key); ?>" <?php if($key==0): ?> class="active" <?php endif; ?>>
                                        <a class="router-link" href="<?php echo e(url('main/'.$value->url)); ?>"><?php echo e($value->name); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>

                        <div class="child_list">
                            <?php $__currentLoopData = $catList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div  <?php if($key==0): ?> style="display: block" <?php endif; ?> class="child_list_div category-list-<?php echo e($key); ?> ">
                                    <div class="show-total-sub-cat">
                                        <a class="router-link" href="<?php echo e(url('main/'.$value->url)); ?>">
                                            <span>مشاهده تمام دسته های </span>
                                            <span><?php echo e($value->name); ?></span>
                                        </a>
                                    </div>
                                    <?php if(sizeof($value->getChild)>0): ?>
                                        <?php
                                        $c=0;
                                        ?>
                                        <?php if(sizeof($value->getChild)>0): ?> <?php if($c==0): ?> <ul class="list-inline subList"> <?php endif; ?> <?php endif; ?>
                                            <?php $__currentLoopData = $value->getChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2=>$value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($value2->notShow==0): ?>
                                                    <?php if(get_show_category_count($value2->getChild)>=(14-$c)): ?> <?php $c=0 ?>  </ul> <ul class="list-inline subList"> <?php endif; ?>
                                            <li>
                                                <a class="child_cat router-link" href="<?php echo e(get_cat_url($value2)); ?>">
                                                    <span class="fa fa-angle-left"></span>
                                                    <span><?php echo e($value2->name); ?></span>
                                                </a>
                                                <ul>
                                                    <?php $__currentLoopData = $value2->getChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key3=>$value3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($value3->notShow==0): ?>
                                                            <li>
                                                                <a class="router-link" href="<?php echo e(get_cat_url($value3)); ?>"><?php echo e($value3->name); ?></a>
                                                            </li>
                                                            <?php $c++; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </li>
                                            <?php $c++ ?>
                                            <?php if($c==13): ?>  </ul> <?php $c=0; ?> <ul class="list-inline subList"> <?php endif; ?>
                                            <?php else: ?>
                                                <?php $__currentLoopData = $value2->getChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key3=>$value3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(get_show_category_count($value3->getChild)>=(14-$c)): ?> <?php $c=0 ?>  </ul> <ul class="list-inline subList"> <?php endif; ?>
                                            <?php if($value3->notShow==0): ?>
                                                <li>
                                                    <a class="child_cat router-link" href="<?php echo e(get_cat_url($value3)); ?>">
                                                        <span class="fa fa-angle-left"></span>
                                                        <span><?php echo e($value3->name); ?></span>
                                                    </a>
                                                    <ul>
                                                        <?php $__currentLoopData = $value3->getChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key4=>$value4): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($value4->notShow==0): ?>
                                                                <li>
                                                                    <a class="router-link" href="<?php echo e(get_cat_url($value4)); ?>"><?php echo e($value4->name); ?></a>
                                                                </li>
                                                                <?php $c++; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </li>
                                                <?php $c++; ?>

                                            <?php endif; ?>

                                            <?php if($c==13): ?>  </ul> <?php $c=0; ?> <ul class="list-inline subList"> <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php if($c!=0): ?> </ul> <?php endif; ?>

                                        <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                </div>

            </li>
            <li  class="shop_nav_li">
                <a href="">
                    <span class="fa fa-gift"></span>
                    <span>تخفیف‌ها و پیشنهادها</span>
                </a>
            </li>
            <li  class="shop_nav_li">
                <a href="<?php echo e(url('faq')); ?>" class="router-link">
                    <span>سوالی دارید؟</span>
                </a>
            </li>
            <li class="shop_nav_li">
                <a href="<?php echo e(url('sellers/login')); ?>">
                    <span>فروشنده شوید</span>
                </a>
            </li>
        </ul>

        <select-cites selected="<?php echo e(Cookie::get('selected_shop_cites')); ?>"></select-cites>

    </div>
</shop-nav>
<?php /**PATH /home/teraketc/AppCode/themes/theme1/views/categoryList.blade.php ENDPATH**/ ?>