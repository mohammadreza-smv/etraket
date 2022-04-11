<v-card elevation="1" class="profile_menu">

    <div class="profile_menu_header">حساب کاربری شما</div>
    <?php $active='' ?>
    <?php
      $sideBarMenu=[];
      $sideBarMenu[0]=['label'=>'پروفایل','icon'=>'fa fa-user','url'=>url('user/profile')];
      $sideBarMenu=CompleteData('user_panel_menu',$sideBarMenu);
    ?>
    <ul class="profile_menu_ul">
        <?php $__currentLoopData = $sideBarMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e($menu['url']); ?>" class="router-link">
                    <v-icon><?php echo e($menu['icon']); ?></v-icon>
                    <?php echo e($menu['label']); ?>

                </a>
                <?php if(array_key_exists('count',$menu)): ?>
                    <?php if(isset(${$menu['count']}) && ${$menu['count']}>0): ?>
                        <span class="count_span"><?php echo e(replace_number(${$menu['count']})); ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

</v-card>
<?php /**PATH /home2/teraketc/AppCode/themes/theme1/views/user_panel_menu.blade.php ENDPATH**/ ?>