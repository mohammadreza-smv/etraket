<?php $__env->startSection('content'); ?>

  <v-row class="category-page">

      <div class="catlist">

         <v-card>

             <v-card-title class="child-cat-list-title">
                 دسته بندی کالاها
             </v-card-title>

             <v-card-text>

                 <?php $__currentLoopData = $category->getChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                     <div class="child-cat-list">
                         <a href="<?php echo e(get_cat_url($value)); ?>" class="cat-name router-link">
                             <?php echo e($value['name']); ?>

                         </a>
                         <?php if(sizeof($value['getChild'])>0): ?>
                             <?php if(sizeof($value['getChild'])>5): ?> <child-cat-ul id="child-cat-<?php echo e($value->id); ?>"> <?php endif; ?>
                                 <ul <?php if(sizeof($value['getChild'])>5): ?> id="child-cat-<?php echo e($value->id); ?>" <?php endif; ?>>
                                     <?php $__currentLoopData = $value['getChild']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2=>$value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <li>
                                             <a href="<?php echo e(get_cat_url($value)); ?>" class="router-link">
                                                 <?php echo e($value2['name']); ?>

                                             </a>
                                         </li>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </ul>
                             <?php if(sizeof($value['getChild'])>5): ?> </child-cat-ul> <?php endif; ?>
                         <?php endif; ?>
                     </div>

                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

             </v-card-text>

         </v-card>

      </div>

      <div class="content">

          <?php if ($__env->exists('themes::widgets.view',['location'=>'desktop_main_cat:widgetParam'])) echo $__env->make('themes::widgets.view',['location'=>'desktop_main_cat:widgetParam'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      </div>

  </v-row>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/themes/theme1/views/child_cat.blade.php ENDPATH**/ ?>