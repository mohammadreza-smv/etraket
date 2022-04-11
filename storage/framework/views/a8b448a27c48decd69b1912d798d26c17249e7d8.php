<header>
    <div class="blog-header">

        <div class="logo-box">
            <div style="display: flex;align-items: center">
                <div>
                    <img src="<?php echo e(asset(config('shop-info.shop_icon'))); ?>" class="logo">
                </div>
                <div class="blog-title">
                    <a href="<?php echo e(route('blog.index')); ?>" class="router-link" >
                        <span>وبلاگ</span>
                        <span><?php echo e(config('shop-info.shop_name')); ?></span>
                    </a>
                </div>
            </div>

            <div>
                <div class="category-navigation-drawer">

                    <v-app-bar-nav-icon @click="$root.$emit('show_navigation_drawer')"></v-app-bar-nav-icon>

                    <category-navigation-drawer>
                        <?php if(isset($categories)): ?>
                            <ul class="nav-blog-categories">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-parent-li">
                                        <a  <?php if(sizeof($cat->child)==0): ?>
                                            href="<?php echo e(route('blog.cat.posts', ['cat1' => $cat->url])); ?>" class="router-link" <?php else: ?>
                                            class="parent-link" <?php endif; ?>  >
                                            <?php echo e($cat->name); ?>

                                            <?php if(sizeof($cat->child)>0): ?>
                                                <v-icon>mdi-chevron-down</v-icon>
                                            <?php endif; ?>
                                        </a>
                                        <?php if(sizeof($cat->child)>0): ?>
                                            <ul class="nav-child-cat">
                                                <?php $__currentLoopData = $cat->child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <a  href="<?php echo e(route('blog.cat.posts', ['cat1' => $cat->url,'cat2' => $child->url])); ?>" class="router-link child-link">
                                                            <?php echo e($child->name); ?>

                                                        </a>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </category-navigation-drawer>

                </div>
            </div>
        </div>

        <div>
            <menu-list>
                <?php if(isset($categories)): ?>
                    <ul class="blog-categories">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="parent-li">
                                <a  href="<?php echo e(route('blog.cat.posts', ['cat1' => $cat->url])); ?>" class="router-link " >
                                    <?php echo e($cat->name); ?>

                                    <?php if(sizeof($cat->child)>0): ?>
                                        <v-icon>mdi-chevron-down</v-icon>
                                    <?php endif; ?>
                                </a>
                                <?php if(sizeof($cat->child)>0): ?>
                                    <ul class="child-menu">
                                        <?php $__currentLoopData = $cat->child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <a  href="<?php echo e(route('blog.cat.posts', ['cat1' => $cat->url,'cat2' => $child->url])); ?>" class="router-link">
                                                    <?php echo e($child->name); ?>

                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </menu-list>
        </div>

    </div>
</header>
<?php /**PATH /home2/teraketc/AppCode/modules/blog/resource/views/header.blade.php ENDPATH**/ ?>