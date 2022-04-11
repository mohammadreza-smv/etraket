<?php
  $create_param='';
  $trash_param='';
  if(isset($queryString) && is_array($queryString))
  {
      $create_param='?'.$queryString['param'].'='.$queryString['value'];
      $trash_param='&'.$queryString['param'].'='.$queryString['value'];
  }
?>


<div>
    <panel-menu-box>

        <template slot="items">
            <?php if(!isset($remove_new_record) || $remove_new_record==false): ?>
                <v-list-item>
                    <v-list-item-icon><v-icon>mdi-pencil</v-icon></v-list-item-icon>
                    <v-list-item-title>
                        <a class="router-link"  href="<?php echo e(url($route.'/create').$create_param); ?>">
                            افزودن <?php echo e($title); ?> جدید
                        </a>
                    </v-list-item-title>
                </v-list-item>
            <?php endif; ?>

            <v-list-item>
                <v-list-item-icon><v-icon>mdi-delete</v-icon></v-list-item-icon>
                <v-list-item-title>
                    <a  class="router-link"  href="<?php echo e(url($route.'?trashed=true').$trash_param); ?>">
                        سطل زباله (<?php echo e(replace_number($count)); ?>)
                    </a>
                </v-list-item-title>
            </v-list-item>


            <delete-multiple title="<?php echo e($title); ?>" ></delete-multiple>

            <restore-multiple title="<?php echo e($title); ?>" ></restore-multiple>

                <?php if(isset($other)): ?>
                    <?php $__currentLoopData = $other; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <v-list-item>
                            <v-list-item-icon><v-icon><?php echo e($item['icon']); ?></v-icon></v-list-item-icon>

                            <v-list-item-title>
                                <a <?php if(!array_key_exists('target',$item)): ?> class="router-link" <?php endif; ?> href="<?php echo e($item['url']); ?>">
                                    <?php echo e($item['label']); ?>

                                </a>
                            </v-list-item-title>

                        </v-list-item>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

        </template>

    </panel-menu-box>

</div>

<?php /**PATH /home/teraketc/AppCode/themes/AdminPanel/item_table.blade.php ENDPATH**/ ?>